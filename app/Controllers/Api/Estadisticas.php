<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ComentariosModel;
use App\Models\ReclamoModel;
use App\Models\UsuarioModel;
use App\Models\CategoriaModel;
use App\Models\ProvinciaModel;

class Estadisticas extends ResourceController
{
    protected $format = 'json';

    protected $usuariosModel;
    protected $comentariosModel;
    protected $reclamosModel;
    protected $categoriaModel;
    protected $provinciaModel;

    public function __construct()
    {
        $this->usuariosModel = new UsuarioModel();
        $this->comentariosModel = new ComentariosModel();
        $this->reclamosModel = new ReclamoModel();
        $this->categoriaModel = new CategoriaModel();
        $this->provinciaModel = new ProvinciaModel();
    }

    /**
     * Endpoint principal: estadísticas globales
     */
    public function index()
    {
        $datos = [
            'total_usuarios' => $this->usuariosModel->countAllResults(),
            'reclamos_totales' => $this->reclamosModel->countAllResults(),
            'reclamos_resueltos' => $this->reclamosModel->where('estado', 'solucionado')->countAllResults(),
            'reclamos_pendientes' => $this->reclamosModel->where('estado', 'pendiente')->countAllResults(),
            'reclamos_en_proceso' => $this->reclamosModel->where('estado', 'en_proceso')->countAllResults(),
        ];

        return $this->respond($datos);
    }

    /**
     * Reclamos agrupados por categoría
     */
    public function porCategoria()
    {
        $resultado = $this->reclamosModel
            ->select('categorias.nombre_categoria as categoria, COUNT(reclamos.id) as total')
            ->join('categorias', 'categorias.id = reclamos.categoria_id')
            ->groupBy('categorias.id, categorias.nombre_categoria')
            ->orderBy('total', 'DESC')
            ->findAll();

        return $this->respond($resultado);
    }

    /**
     * Reclamos agrupados por provincia
     */
    public function porProvincia()
    {
        $resultado = $this->reclamosModel
            ->select('provincia.nombre_provincia, COUNT(reclamos.id) as total')
            ->join('usuarios', 'usuarios.id = reclamos.usuario_id')
            ->join('provincia', 'provincia.codigo_provincia = usuarios.provincia_id')
            ->groupBy('usuarios.provincia_id, provincia.nombre_provincia')
            ->orderBy('total', 'DESC')
            ->findAll();

        return $this->respond($resultado);
    }

    /**
     * Cantidad de comentarios activos (sin eliminación)
     */
    public function totalComentarios()
    {
        $total = $this->comentariosModel->where('fecha_eliminacion IS NULL')->countAllResults();
        return $this->respond(['total_comentarios' => $total]);
    }
}
