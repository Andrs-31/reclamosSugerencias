<?php
namespace App\Controllers;

class Admin extends BaseController
{
    public function dashboard()
    {
        return view('admin/dashboard', ['titulo' => 'Dashboard']);
    }

    public function reclamosList()
    {
        return view('admin/reclamos_list', ['titulo' => 'Reclamos Registrados']);
    }
}