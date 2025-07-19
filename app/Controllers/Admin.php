<?php
namespace App\Controllers;

use App\Models\ComentariosModel;
use App\Models\ReclamoModel;
use App\Models\UsuarioModel;
use App\Models\CategoriaModel;
use App\Models\RolModel;
use App\Models\ProvinciaModel; // ✅ Importación correcta

class Admin extends BaseController
{
    protected $usuariosModel;
    protected $comentariosModel;
    protected $reclamosModel;
    protected $categoriaModel;
    protected $rolModel;
    protected $provinciaModel; // ✅ Declaración de propiedad

    public function __construct()
    {
        $this->usuariosModel = new UsuarioModel();
        $this->comentariosModel = new ComentariosModel();
        $this->reclamosModel = new ReclamoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->rolModel = new RolModel();
        $this->provinciaModel = new ProvinciaModel(); // ✅ Instancia asignada correctamente
    }

    /**
     * Obtiene los conteos de reclamos por estado.
     * @return array
     */
    protected function _getReclamoCounts(): array
    {
        return [
            'totalReclamos' => $this->reclamosModel->countAllResults(),
            'reclamosPendientes' => $this->reclamosModel->where('estado', 'pendiente')->countAllResults(),
            'reclamosEnProceso' => $this->reclamosModel->where('estado', 'en_proceso')->countAllResults(),
            'reclamosSolucionados' => $this->reclamosModel->where('estado', 'solucionado')->countAllResults(),
        ];
    }
    public function obtenerReclamoCounts()
    {
        return $this->response->setJSON($this->_getReclamoCounts());
    }

    public function dashboard()
        {
            // Obtener conteos básicos
            $counts = $this->_getReclamoCounts();
            
            // Obtener datos para el gráfico por provincia
            $reclamosPorProvincia = $this->reclamosModel
                ->select('provincia.nombre_provincia, COUNT(reclamos.id) as total')
                ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
                ->join('provincia', 'provincia.codigo_provincia = usuarios.provincia_id')
                ->groupBy('usuarios.provincia_id, provincia.nombre_provincia')
                ->orderBy('total', 'DESC')
                ->findAll();

            $data = [
                'titulo' => 'Dashboard',
                'reclamosPorProvincia' => $reclamosPorProvincia,
                'provincias' => $this->provinciaModel->findAll() // Para referencia si la necesitas
            ];

            // Fusionar con los conteos existentes
            return view('admin/dashboard', array_merge($data, $counts));
        }

    public function reclamosList($status = null)
    {
        $usuarios = $this->usuariosModel->findAll();
        $categorias = $this->categoriaModel->findAll();
        $provincias = $this->provinciaModel->findAll();

        // Obtener parámetros de filtro
        $searchTerm = $this->request->getGet('search');
        $provincia = $this->request->getGet('provincia');
        $distrito = $this->request->getGet('distrito');
        $corregimiento = $this->request->getGet('corregimiento');

        // Construir la consulta base con joins necesarios
        $reclamosQuery = $this->reclamosModel
            ->select('reclamos.*, usuarios.nombre, categorias.nombre_categoria, 
                    usuarios.provincia_id, usuarios.distrito_id, usuarios.corregimiento_id')
            ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
            ->join('categorias', 'categorias.id = reclamos.categoria_id');

        // Filtro por estado
        if ($status && in_array($status, ['pendiente', 'en_proceso', 'solucionado'])) {
            $reclamosQuery->where('reclamos.estado', $status);
        }

        // Búsqueda general (independiente de ubicación)
        if ($searchTerm) {
            $reclamosQuery->groupStart()
                ->like('reclamos.descripcion', $searchTerm)
                ->orLike('usuarios.nombre', $searchTerm)
                ->orLike('categorias.nombre_categoria', $searchTerm)
                ->groupEnd();
        }

        // Filtros de ubicación del usuario (opcionales)
        if ($provincia) {
            $reclamosQuery->where('usuarios.provincia_id', $provincia);

            if ($distrito) {
                $reclamosQuery->where('usuarios.distrito_id', $distrito);

                if ($corregimiento) {
                    $reclamosQuery->where('usuarios.corregimiento_id', $corregimiento);
                }
            }
        }

        $reclamos = $reclamosQuery->findAll();

        $data = [
            'titulo' => 'Lista de Reclamos',
            'reclamos' => $reclamos,
            'usuariosMap' => array_column($usuarios, 'nombre', 'id'),
            'categoriasMap' => array_column($categorias, 'nombre_categoria', 'id'),
            'currentStatusFilter' => $status,
            'searchTerm' => $searchTerm,
            'provincias' => $provincias,
            // Mantener los valores seleccionados para los dropdowns
            'selectedProvincia' => $provincia,
            'selectedDistrito' => $distrito,
            'selectedCorregimiento' => $corregimiento
        ];

        $data = array_merge($data, $this->_getReclamoCounts());

        return view('admin/reclamos_list', $data);
    }

    public function getReclamo($id) 
    {
        $reclamo = $this->reclamosModel
        ->select('reclamos.*, 
            usuarios.nombre,
            categorias.nombre_categoria,
            provincia.nombre_provincia,
            distrito.nombre_distrito,
            corregimiento.nombre_corregimiento,
            CONCAT_WS(", ", provincia.nombre_provincia, distrito.nombre_distrito, corregimiento.nombre_corregimiento) as direccion_completa')
        ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
        ->join('categorias', 'categorias.id = reclamos.categoria_id')
        ->join('provincia', 'provincia.codigo_provincia = usuarios.provincia_id', 'left')
        ->join('distrito', 'distrito.codigo_distrito = usuarios.distrito_id AND distrito.codigo_provincia = usuarios.provincia_id', 'left')
        ->join('corregimiento', 'corregimiento.codigo_corregimiento = usuarios.corregimiento_id AND corregimiento.codigo_distrito = usuarios.distrito_id AND corregimiento.codigo_provincia = usuarios.provincia_id', 'left')
        ->where('reclamos.id', $id)
        ->first();
        
        if (!$reclamo) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Reclamo no encontrado']);
        }
        return $this->response->setJSON($reclamo);
    }

public function getComentarios($reclamoId) {
    $comentarios = $this->comentariosModel
        ->select('comentarios.*, usuarios.nombre as autor')
        ->join('usuarios', 'usuarios.id = comentarios.usuario_id')
        ->where('comentarios.reclamo_id', $reclamoId)
        ->orderBy('comentarios.fecha', 'ASC')
        ->findAll();
        
    return $this->response->setJSON($comentarios);
}


public function agregarComentario()
{
    $reclamoModel = new \App\Models\ReclamoModel();
    $comentarioModel = new \App\Models\ComentariosModel();
    //$userId = 1; // Usuario de prueba
    $userId = session()->get('user_id');

    try {
        $input = $this->request->getJSON(true);
        
        // Validación básica
        if (empty($input['reclamo_id']) || empty($input['comentario']) || empty($input['new_status'])) {
            throw new \RuntimeException('Todos los campos son requeridos');
        }

        // Verificar si ya existe un comentario idéntico reciente
        $existingComment = $comentarioModel
            ->where('reclamo_id', $input['reclamo_id'])
            ->where('usuario_id', $userId)
            ->where('comentario', $input['comentario'])
            ->orderBy('fecha', 'DESC')
            ->first();

        if ($existingComment && strtotime($existingComment['fecha']) > (time() - 60)) {
            throw new \RuntimeException('Has enviado un comentario idéntico recientemente');
        }

        // Insertar comentario
        $comentarioData = [
            'reclamo_id' => $input['reclamo_id'],
            'usuario_id' => $userId,
            'comentario' => $input['comentario']
        ];
        
        if (!$comentarioModel->insert($comentarioData)) {
            throw new \RuntimeException('Error al insertar comentario');
        }

        // Actualizar estado del reclamo
        $reclamoModel->update($input['reclamo_id'], [
            'estado' => $input['new_status'],
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ]);

        
        // Obtener el email del ciudadano
        $reclamo = $reclamoModel
            ->select('reclamos.*, usuarios.email as ciudadano_email')
            ->join('usuarios', 'usuarios.id = reclamos.usuario_id') // ajusta si usas cédula u otro ID
            ->find($input['reclamo_id']);

        if ($reclamo && !empty($reclamo['ciudadano_email'])) {
            $email = \Config\Services::email();

            $email->setTo($reclamo['ciudadano_email']);
            $email->setSubject('Actualización en su reclamo');
            $email->setMessage(
                "<p>Estimado ciudadano,</p>
                <p>Se ha agregado un nuevo comentario a su reclamo <strong>#{$input['reclamo_id']}</strong>.</p>
                <p><strong>Comentario:</strong> {$input['comentario']}</p>
                <p><strong>Nuevo estado:</strong> {$input['new_status']}</p>
                <p>Gracias por utilizar nuestra plataforma.</p>"
            );

            if (!$email->send()) {
                log_message('error', 'Error al enviar correo: ' . print_r($email->printDebugger(['headers']), true));
            }
        }
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Comentario agregado exitosamente'
        ]);


    } catch (\Exception $e) {
        return $this->response->setStatusCode(400)->setJSON([
            'error' => $e->getMessage()
        ]);
    }
}



// Métodos para Categorías
public function categoriasList()
{
    $categorias = $this->categoriaModel->findAll();
    $data = [
            'titulo' => 'Gestión de Categorías',
            'categorias' => $categorias
        ];
        // Fusionar los conteos de reclamos con los datos de la vista
        $data = array_merge($data, $this->_getReclamoCounts());
        return view('admin/categorias_list', $data);
    }

    public function saveCategoria()
    {
        $id = $this->request->getPost('id');
        $nombre_categoria = $this->request->getPost('nombre_categoria');
        $descripcion = $this->request->getPost('descripcion');

        if (empty($nombre_categoria)) {
            return redirect()->back()->with('error', 'El nombre de la categoría no puede estar vacío.');
        }

        $data = [
            'nombre_categoria' => $nombre_categoria,
            'descripcion' => $descripcion
        ];

        if ($id) {
            // Actualizar categoría existente
            $this->categoriaModel->update($id, $data);
            return redirect()->to(base_url('categorias'))->with('success', 'Categoría actualizada exitosamente.');
        } else {
            // Añadir nueva categoría
            $this->categoriaModel->insert($data);
            return redirect()->to(base_url('categorias'))->with('success', 'Categoría añadida exitosamente.');
        }
    }

    public function deleteCategoria($id)
    {
        if ($this->categoriaModel->delete($id)) {
            return redirect()->to(base_url('categorias'))->with('success', 'Categoría eliminada exitosamente.');
        } else {
            return redirect()->to(base_url('categorias'))->with('error', 'No se pudo eliminar la categoría.');
        }
    }

    // Métodos para Ciudadanos
    public function ciudadanosList()
    {
        // Obtener solo usuarios con rol_id = 1 (ciudadano)
        $ciudadanos = $this->usuariosModel->where('rol_id', 1)->findAll();
        $roles = $this->rolModel->findAll(); // Para mostrar el nombre del rol si es necesario

        $rolesMap = [];
        foreach ($roles as $rol) {
            $rolesMap[$rol['id']] = $rol['nombre_rol'];
        }

        $data = [
            'titulo' => 'Gestión de Ciudadanos',
            'ciudadanos' => $ciudadanos,
            'rolesMap' => $rolesMap
        ];
        // Fusionar los conteos de reclamos con los datos de la vista
        $data = array_merge($data, $this->_getReclamoCounts());

        return view('admin/ciudadanos_list', $data);
    }

    public function saveCiudadano()
    {
        $id = $this->request->getPost('id');
        $nombre_usuario = $this->request->getPost('nombre');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($nombre_usuario) || empty($email)) {
            return redirect()->back()->with('error', 'Nombre de usuario y email no pueden estar vacíos.');
        }

        $data = [
            'nombre' => $nombre_usuario,
            'email' => $email,
        ];

        if (!empty($password)) {
            $data['password'] = $password;
        }

        if ($id) {
            // Actualizar ciudadano existente
            $this->usuariosModel->update($id, $data);
            return redirect()->to(base_url('ciudadanos'))->with('success', 'Ciudadano actualizado exitosamente.');
        } else {
            // Esto no debería ocurrir si solo se editan ciudadanos existentes
            return redirect()->back()->with('error', 'Operación no válida para añadir un nuevo ciudadano desde aquí.');
        }
    }

    public function deleteCiudadano($id)
    {
        // No se permite eliminar ciudadanos según la solicitud actual
        return redirect()->to(base_url('ciudadanos'))->with('error', 'La eliminación de ciudadanos no está permitida.');
    }
}
