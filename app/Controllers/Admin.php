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
        
        // Reclamos por provincia
        $reclamosPorProvincia = $this->reclamosModel
            ->select('provincia.nombre_provincia, COUNT(reclamos.id) as total')
            ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
            ->join('provincia', 'provincia.codigo_provincia = usuarios.provincia_id')
            ->groupBy('usuarios.provincia_id, provincia.nombre_provincia')
            ->orderBy('total', 'DESC')
            ->findAll();

        // Reclamos por categoría
        $reclamosPorCategoria = $this->reclamosModel
            ->select('categorias.nombre_categoria as categoria, COUNT(reclamos.id) as total')
            ->join('categorias', 'categorias.id = reclamos.categoria_id')
            ->groupBy('categorias.id, categorias.nombre_categoria')
            ->orderBy('total', 'DESC')
            ->findAll();

        $data = [
            'titulo' => 'Dashboard',
            'reclamosPorProvincia' => $reclamosPorProvincia,
            'reclamosPorCategoria' => $reclamosPorCategoria,
            'provincias' => $this->provinciaModel->findAll(),
            'categorias' => $this->categoriaModel->findAll()
        ];

        return view('admin/dashboard', array_merge($data, $counts));
    }

    public function reclamosList($statusOrUserId= null)
    {
        log_message('debug', 'Reclamos List - Status or ID: ' . $statusOrUserId);
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
        
         
        $status = null;
        // Lógica de filtrado mejorada
        if (is_numeric($statusOrUserId)) {
            // Es un ID de usuario
            $reclamosQuery->where('reclamos.usuario_id', $statusOrUserId);
            log_message('debug', 'Filtrando por usuario ID: '.$statusOrUserId);
        } elseif (in_array($statusOrUserId, ['pendiente', 'en_proceso', 'solucionado'])) {
            // Es un estado válido
            $reclamosQuery->where('reclamos.estado', $statusOrUserId);
            $status = $statusOrUserId; // Guardar el estado para la vista
            log_message('debug', 'Filtrando por estado: '.$statusOrUserId);
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
    try {
        // Validar que el reclamo exista
        $reclamoModel = new \App\Models\ReclamoModel();
        if (!$reclamoModel->find($reclamoId)) {
            return $this->response->setStatusCode(404)->setJSON([
                'error' => 'El reclamo no existe'
            ]);
        }

        $comentarios = $this->comentariosModel
            ->select('comentarios.*, usuarios.nombre as autor')
            ->join('usuarios', 'usuarios.id = comentarios.usuario_id')
            ->where('comentarios.reclamo_id', $reclamoId)
            ->orderBy('comentarios.fecha', 'desc')
            ->findAll();
            
        return $this->response->setJSON($comentarios);
        
    } catch (\Exception $e) {
        log_message('error', 'Error en getComentarios: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'error' => 'Error interno al obtener comentarios'
        ]);
    }
}

public function agregarComentario() {
    $reclamoModel = new \App\Models\ReclamoModel();
    $comentarioModel = new \App\Models\ComentariosModel();
    $userId = session()->get('user_id');

    try {
        // Verificar sesión
        if (!$userId) {
            throw new \RuntimeException('Debe iniciar sesión para comentar', 401);
        }

        $input = $this->request->getJSON(true);
        
        // Validación de campos
        $validation = \Config\Services::validation();
        $validation->setRules([
            'reclamo_id' => 'required|numeric',
            'comentario' => 'required|min_length[5]|max_length[2000]',
            'new_status' => 'required|in_list[pendiente,en_proceso,solucionado]'
        ]);

        if (!$validation->run((array)$input)) {
            $errors = $validation->getErrors();
            throw new \RuntimeException(implode("\n", $errors), 400);
        }

        // Verificar que el reclamo existe
        $reclamo = $reclamoModel->find($input['reclamo_id']);
        if (!$reclamo) {
            throw new \RuntimeException('El reclamo no existe', 404);
        }

        // Verificar comentario duplicado reciente
        $existingComment = $comentarioModel
            ->where('reclamo_id', $input['reclamo_id'])
            ->where('usuario_id', $userId)
            ->where('comentario', $input['comentario'])
            ->orderBy('fecha', 'DESC')
            ->first();

        if ($existingComment && strtotime($existingComment['fecha']) > (time() - 60)) {
            throw new \RuntimeException('Has enviado un comentario idéntico recientemente. Por favor espera un momento antes de enviar el mismo comentario nuevamente.');
        }

        
        // Insertar comentario
        $comentarioData = [
            'reclamo_id' => $input['reclamo_id'],
            'usuario_id' => $userId,
            'comentario' => $input['comentario'],
            'fecha_creacion' => date('Y-m-d H:i:s')  // <- Aquí agregas la hora manual
        ];

        
        if (!$comentarioModel->save($comentarioData)) {
            throw new \RuntimeException('Error al guardar el comentario');
        }

        // Actualizar estado del reclamo
        if (!$reclamoModel->update($input['reclamo_id'], [
            'estado' => $input['new_status'],
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ])) {
            throw new \RuntimeException('Error al actualizar el estado del reclamo');
        }
        
        // Enviar notificación por correo
        $this->enviarNotificacionEmail($input['reclamo_id'], $input['comentario'], $input['new_status']);
        
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Comentario agregado exitosamente. Hora actual PHP: ' . date('Y-m-d H:i:s'),
            'data' => [
                'comentario_id' => $comentarioModel->getInsertID()
            ]
        ]);

    } catch (\RuntimeException $e) {
        $statusCode = $e->getCode() >= 400 && $e->getCode() < 600 ? $e->getCode() : 400;
        return $this->response->setStatusCode($statusCode)->setJSON([
            'error' => $e->getMessage()
        ]);
    } catch (\Exception $e) {
        log_message('error', 'Error en agregarComentario: ' . $e->getMessage());
        return $this->response->setStatusCode(500)->setJSON([
            'error' => 'Ocurrió un error interno al procesar tu comentario'
        ]);
    }
}

private function enviarNotificacionEmail($reclamoId, $comentario, $estado) {
    try {
        $reclamoModel = new \App\Models\ReclamoModel();
        $reclamo = $reclamoModel
            ->select('reclamos.*, usuarios.email as ciudadano_email')
            ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
            ->find($reclamoId);

        if (!$reclamo || empty($reclamo['ciudadano_email'])) {
            return false;
        }

        $email = \Config\Services::email();
        $email->setTo($reclamo['ciudadano_email']);
        $email->setSubject("Actualización en su reclamo #{$reclamoId}");
        
        $estadoTexto = str_replace('_', ' ', $estado);
        $estadoTexto = ucfirst($estadoTexto);
        
        $message = view('emails/actualizacion_reclamo', [
            'reclamoId' => $reclamoId,
            'comentario' => $comentario,
            'estado' => $estadoTexto
        ]);
        
        $email->setMessage($message);
        
        if (!$email->send()) {
            log_message('error', 'Error al enviar email: ' . $email->printDebugger(['headers']));
            return false;
        }
        
        return true;
    } catch (\Exception $e) {
        log_message('error', 'Error enviando notificación: ' . $e->getMessage());
        return false;
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
