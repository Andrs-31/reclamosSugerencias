<?php
namespace App\Controllers;

use App\Models\UsersModel;

class Login extends BaseController
{
    public function index()
    {
        session()->destroy();  // Destruye la sesión al acceder a la página de login
        return view('Auth/login'); // Muestra la vista de login
    }

    public function login()
    {

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', [
                'validation' => $this->validator
            ]);
        }

        $userModel = new UsersModel();
        $post = $this->request->getPost(['username', 'password']);

        $user = $userModel->validateUser($post['username'], $post['password']);

        if ($user) {
            // Autenticación exitosa, setea la sesión y redirige
            session()->set('logged_in', true);
            session()->set('user_id', $user['id']);
            session()->set('username', $user['usuario']);
            session()->set('rol_id', $user['rol_id']);
            session()->set('nombre', $user['nombre']);
            session()->set('email', $user['email']);

            // Redirigir según el rol
            if ($user['rol_id'] == 2) {
                return redirect()->to('/admin/dashboard');
            } else {
                return redirect()->to('/ciudadano/dashboard');
            }
        } else {
            session()->setFlashdata('error', 'Usuario/correo o contraseña incorrectos');
            return redirect()->back()->withInput();
        }
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}