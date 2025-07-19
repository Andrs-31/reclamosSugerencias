<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $rol = $session->get('rol_id');

        // Si no está logueado, redirige a login
        if (!$session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Si la ruta es de admin y no es admin
        if (in_array('admin', $arguments) && $rol != 2) {
            return redirect()->to('/ciudadano/dashboard');
        }

        // Si la ruta es de ciudadano y no es ciudadano
        if (in_array('ciudadano', $arguments) && $rol != 1) {
            return redirect()->to('/admin/dashboard');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No se necesita lógica post-request
    }
}