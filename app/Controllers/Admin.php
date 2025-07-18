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
            ->select('reclamos.*, usuarios.nombre_usuario, categorias.nombre_categoria, 
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
                ->orLike('usuarios.nombre_usuario', $searchTerm)
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
            'usuariosMap' => array_column($usuarios, 'nombre_usuario', 'id'),
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
        $nombre_usuario = $this->request->getPost('nombre_usuario');
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($nombre_usuario) || empty($email)) {
            return redirect()->back()->with('error', 'Nombre de usuario y email no pueden estar vacíos.');
        }

        $data = [
            'nombre_usuario' => $nombre_usuario,
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
