<?php

namespace App\Controllers;

use App\Models\UsersModel;

class Auth extends BaseController
{
    protected $helpers = ['form'];

    public function register()
    {
        $provinciaModel = new \App\Models\ProvinciaModel();
        $provincias = $provinciaModel->findAll();

        // RETORNAMOS LAS PROVINCIAS
        return view('auth/register', [
            'provincias' => $provincias
        ]);
    }

    public function create()
    {
        $rules = [
            'user' => 'required|max_length[30]|is_unique[usuarios.usuario]',
            'password' => 'required|max_length[50]|min_length[4]',
            'repassword' => 'matches[password]',
            'name' => 'required|max_length[100]',
            'email' => 'required|max_length[100]|valid_email|is_unique[usuarios.email]',
            'provincia' => 'required|max_length[2]',
            'distrito' => 'required|max_length[4]',
            'corregimiento' => 'required|max_length[6]',
        ];

        if (!$this->validate($rules)) {
            $provinciaModel = new \App\Models\ProvinciaModel();
            $provincias = $provinciaModel->findAll();

            return view('auth/register', [
                'validation' => $this->validator,
                'provincias' => $provincias,
                // Puedes pasar también los valores seleccionados si quieres
                'selectedProvincia' => $this->request->getPost('provincia'),
                'selectedDistrito' => $this->request->getPost('distrito'),
                'selectedCorregimiento' => $this->request->getPost('corregimiento'),
            ]);
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost([
            'user', 'password', 'name', 'email', 'provincia', 'distrito', 'corregimiento'
        ]);

        // Aquí el código para guardar el usuario
        // Determinar el rol según el dominio del correo
        $rol_id = 1; // Por defecto
        if (preg_match('/@empresa\.ac\.pa$/', $post['email'])) {
            $rol_id = 2;
        }

        $userModel->insert([
            'usuario' => $post['user'],
            'email' => $post['email'],
            'password' => password_hash($post['password'], PASSWORD_DEFAULT),
            'nombre' => $post['name'],
            'rol_id' => $rol_id,
            'provincia_id' => $post['provincia'],
            'distrito_id' => $post['distrito'],
            'corregimiento_id' => $post['corregimiento']
        ]);

        return redirect()->to('/login')->with('success', 'Registro exitoso');
    }

    public function login()
    {
        return view('auth/login');
    }


}
