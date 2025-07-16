<?php
namespace App\Controllers;

use App\Models\ComentariosModel;
use App\Models\ReclamoModel;
use App\Models\UsuarioModel;
class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard', ['titulo' => 'Dashboard']);
    }

    public function reclamosList()
    {
        $usuariosModel = new UsuarioModel();
        $usuarios = $usuariosModel->findAll();
        $comentariosModel = new ComentariosModel();
        $comentarios = $comentariosModel->findAll();
        $reclamosModel = new ReclamoModel();
        $resultado =$reclamosModel->findAll();
        return view('admin/reclamos_list', ['reclamos' => $resultado, 'comentarios' => $comentarios, 'usuarios' => $usuarios]);
    }
}