<?php
namespace App\Controllers;

use App\Models\ReclamoModel;
use App\Models\CategoriaModel;
use App\Models\ComentariosModel;
use App\Models\UsuarioModel;

class Ciudadano extends BaseController
{
public function dashboard()
{
    $reclamosModel = new \App\Models\ReclamoModel();
    $usuario_id = session()->get('user_id') ?? 1;

    // Estadísticas
    $estadisticas = [
        'pendientes' => $reclamosModel
            ->where('usuario_id', $usuario_id)
            ->where('estado', 'pendiente')
            ->countAllResults(),

        'en_proceso' => $reclamosModel
            ->where('usuario_id', $usuario_id)
            ->where('estado', 'en_proceso')
            ->countAllResults(),

        'solucionados' => $reclamosModel
            ->where('usuario_id', $usuario_id)
            ->whereIn('estado', ['resuelto', 'solucionado'])
            ->countAllResults(),

        'total' => $reclamosModel
            ->where('usuario_id', $usuario_id)
            ->countAllResults()
    ];

    // Reclamos recientes
    $reclamos = $reclamosModel
        ->where('usuario_id', $usuario_id)
        ->orderBy('fecha', 'DESC')
        ->findAll(); // o ->limit(3)->find(); si quieres traer solo 3 directamente

    return view('ciudadano/dashboard', [
        'titulo' => 'Dashboard Ciudadano',
        'estadisticas' => $estadisticas,
        'reclamos' => $reclamos
    ]);
}
     public function misReclamos()
    {
        helper('text');
        // Obtener el ID del usuario de la sesión (esto debe implementarse según tu sistema de autenticación)
        // Por ahora uso un valor temporal
        $usuario_id = session()->get('user_id') ?? 1; // Cambiar según tu implementación de sesiones
        
        $reclamosModel = new ReclamoModel();
        $categoriasModel = new CategoriaModel();
        $comentariosModel = new ComentariosModel();
        
        // Obtener reclamos con join para incluir el nombre de la categoría (SIN duplicados)
        $reclamos = $reclamosModel
            ->select('reclamos.*, categorias.nombre_categoria as categoria_nombre')
            ->join('categorias', 'categorias.id = reclamos.categoria_id', 'left')
            ->where('reclamos.usuario_id', $usuario_id)
            ->findAll();
        
        // Para cada reclamo, verificar si tiene respuestas del admin
        foreach ($reclamos as &$reclamo) {
            $tieneRespuesta = $comentariosModel
                ->where('reclamo_id', $reclamo['id'])
                ->where('usuario_id !=', $usuario_id) // Comentarios que NO son del ciudadano (son del admin)
                ->countAllResults();
            
            $reclamo['tiene_respuesta'] = $tieneRespuesta > 0 ? 1 : 0;
        }
        
        return view('ciudadano/mis_reclamos', [
            'reclamos' => $reclamos,
            'titulo' => 'Mis Reclamos'
        ]);
    }


    public function nuevoReclamo()
    {
        $categoriasModel = new CategoriaModel();
        $categorias = $categoriasModel->findAll();
        
        return view('ciudadano/nuevo_reclamo', [
            'categorias' => $categorias,
            'titulo' => 'Nuevo Reclamo'
        ]);
    }

    public function guardarReclamo()
    {
        if (!session()->has('user_id')) {
            return redirect()->to('/login')->with('error', 'Debes iniciar sesión para enviar un reclamo.');
        }

        $reclamosModel = new ReclamoModel();
        $usuario_id = session()->get('user_id');
        
        // Obtener datos del formulario
        $datos = [
            'usuario_id' => $usuario_id,
            'categoria_id' => $this->request->getPost('categoria_id'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => 'pendiente', // Estado inicial
            'fecha' => date('Y-m-d H:i:s')
        ];
        
        // Validaciones
        $validationRules = [
            'categoria_id' => 'required|numeric',
            'descripcion' => 'required|min_length[10]|max_length[1000]'
        ];
        
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                           ->with('error', 'Por favor corrige los errores en el formulario. (Debe tener al menos 10 caracteres y máximo 1000).')
                           ->withInput();
        }
        
        // Validar que la categoría existe
        $categoriasModel = new CategoriaModel();
        $categoria = $categoriasModel->find($datos['categoria_id']);
        if (!$categoria) {
            return redirect()->back()
                           ->with('error', 'La categoría seleccionada no es válida.')
                           ->withInput();
        }
        
        // Guardar el reclamo
        if ($reclamosModel->insert($datos)) {
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('success', 'Tu reclamo ha sido enviado exitosamente. Lo revisaremos pronto.');
        } else {
            return redirect()->back()
                           ->with('error', 'Error al guardar el reclamo. Inténtalo de nuevo.')
                           ->withInput();
        }
    }

    public function editarReclamo($id)
    {
        $reclamosModel = new ReclamoModel();
        $categoriasModel = new CategoriaModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel->where('id', $id)
                                ->where('usuario_id', $usuario_id)
                                ->first();
        
        if (!$reclamo) {
            return redirect()->to('../mis-reclamos')
                           ->with('error', 'Reclamo no encontrado o no tienes permisos para editarlo.');
        }
        
        // Cargar todas las categorías
        $categorias = $categoriasModel->findAll();
        
        return view('ciudadano/editar_reclamo', [
            'reclamo' => $reclamo,
            'categorias' => $categorias,
            'titulo' => 'Editar Reclamo'
        ]);
    }

    public function actualizarReclamo($id)
    {
        $reclamosModel = new ReclamoModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel->where('id', $id)
                        ->where('usuario_id', $usuario_id)
                        ->first();
        
        if (!$reclamo) {
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('error', 'Reclamo no encontrado o no tienes permisos para editarlo.');
        }
        
        // Obtener los datos del formulario
        $datos = [
            'categoria_id' => $this->request->getPost('categoria_id'),
            'descripcion' => $this->request->getPost('descripcion'),
            'estado' => $this->request->getPost('estado'),
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];
        
        // Validaciones básicas
        $validationRules = [
            'categoria_id' => 'required|integer',
            'descripcion' => 'required|min_length[10]|max_length[1000]',
            'estado' => 'required'
        ];
        
        if (!$this->validate($validationRules)) {
            return redirect()->back()
                           ->with('error', 'Por favor corrige los errores en el formulario. (Debe tener al menos 10 caracteres y máximo 1000).')
                           ->withInput();
        }
        
        // Validación específica para el estado
        $estadoActual = $reclamo['estado'];
        $nuevoEstado = $datos['estado'];
        
        // Solo permitir cambios de estado específicos
        if (in_array($estadoActual, ['pendiente', 'en_proceso'])) {
            // Desde pendiente o en_proceso solo puede ir a solucionado o mantenerse igual
            if (!in_array($nuevoEstado, ['pendiente', 'en_proceso', 'solucionado'])) {
                return redirect()->back()
                               ->with('error', 'Estado no válido. Solo puedes cambiar a "Solucionado" o mantener el estado actual.')
                               ->withInput();
            }
        } else {
            // Si ya está solucionado, no se puede cambiar
            if ($nuevoEstado != $estadoActual) {
                return redirect()->back()
                               ->with('error', 'No puedes cambiar el estado de un reclamo que ya está solucionado.')
                               ->withInput();
            }
        }
        
        // Validar que la categoría existe
        $categoriasModel = new CategoriaModel();
        $categoria = $categoriasModel->find($datos['categoria_id']);
        if (!$categoria) {
            return redirect()->back()
                           ->with('error', 'La categoría seleccionada no es válida.')
                           ->withInput();
        }
        
        // Actualizar el reclamo
        if ($reclamosModel->update($id, $datos)) {
            $mensaje = 'Tu reclamo ha sido actualizado exitosamente.';
            
            // Mensaje especial si se marcó como solucionado
            if (in_array($estadoActual, ['pendiente', 'en_proceso']) && $nuevoEstado == 'solucionado') {
                $mensaje = '¡Excelente! Tu reclamo ha sido marcado como solucionado.';
            }
            
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('success', $mensaje);
        } else {
            return redirect()->back()
                           ->with('error', 'Error al actualizar el reclamo. Inténtalo de nuevo.')
                           ->withInput();
        }
    }

    public function eliminarReclamo($id)
    {
        // Inicializar el modelo que faltaba
        $reclamosModel = new ReclamoModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que es una petición AJAX
        if (!$this->request->isAJAX()) {
            return redirect()->to('/ciudadano/mis-reclamos');
        }
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel->where('id', $id)
                                ->where('usuario_id', $usuario_id)
                                ->first();
        
        if (!$reclamo) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Reclamo no encontrado o no tienes permisos para eliminarlo.'
            ]);
        }
        
        // Eliminar el reclamo
        if ($reclamosModel->delete($id)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Reclamo eliminado exitosamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error al eliminar el reclamo. Inténtalo de nuevo.'
            ]);
        }
    }
    
    public function verRespuesta($id)
    {
        $reclamosModel = new ReclamoModel();
        $comentariosModel = new ComentariosModel();
        $categoriasModel = new CategoriaModel();
        $usuariosModel = new UsuarioModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel
            ->select('reclamos.*, categorias.nombre_categoria as categoria_nombre')
            ->join('categorias', 'categorias.id = reclamos.categoria_id', 'left')
            ->where('reclamos.id', $id)
            ->where('reclamos.usuario_id', $usuario_id)
            ->first();
        
        if (!$reclamo) {
            return redirect()->to('/ciudadano/mis-reclamos')->with('error', 'Reclamo no encontrado o no tienes permisos para verlo.');
        }
        
        // Obtener TODOS los comentarios del reclamo con información del usuario
        $comentarios = $comentariosModel
            ->select('comentarios.*, usuarios.rol_id')
            ->join('usuarios', 'usuarios.id = comentarios.usuario_id')
            ->where('comentarios.reclamo_id', $id)
            ->orderBy('comentarios.fecha', 'ASC')
            ->findAll();
        
        // Separar comentarios por tipo de usuario basándose en el rol
        $comentariosAdmin = [];
        $comentariosCiudadano = [];
        
        foreach ($comentarios as $comentario) {
            // Si rol_id = 1 es ciudadano, si rol_id = 2 es admin (ajustar según tu BD)
            if ($comentario['rol_id'] == 1) { // Ciudadano
                $comentariosCiudadano[] = $comentario;
            } else { // Admin (rol_id = 2 o cualquier otro)
                $comentariosAdmin[] = $comentario;
            }
        }
        
        return view('ciudadano/ver_respuesta', [
            'reclamo' => $reclamo,
            'comentariosAdmin' => $comentariosAdmin,
            'comentariosCiudadano' => $comentariosCiudadano,
            'todosComentarios' => $comentarios,
            'titulo' => 'Ver Respuesta'
        ]);
    }

    public function responderComentario($id)
    {
        $reclamosModel = new ReclamoModel();
        $comentariosModel = new ComentariosModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel->where('id', $id)
                                ->where('usuario_id', $usuario_id)
                                ->first();
        
        if (!$reclamo) {
            return redirect()->to('../mis-reclamos')
                           ->with('error', 'Reclamo no encontrado o no tienes permisos para responder.');
        }
        
        // Validar que hay respuesta del ciudadano
        $respuesta = $this->request->getPost('respuesta_ciudadano');
        if (empty($respuesta) || strlen($respuesta) < 10) {
            return redirect()->back()
                           ->with('error', 'La respuesta debe tener al menos 10 caracteres.')
                           ->withInput();
        }
        
        // Insertar la respuesta del ciudadano
        $datos = [
            'reclamo_id' => $id,
            'usuario_id' => $usuario_id, // El ciudadano responde
            'comentario' => $respuesta,
            'fecha' => date('Y-m-d H:i:s'),
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];
        
        if ($comentariosModel->insert($datos)) {
            return redirect()->back()
                           ->with('success', 'Tu respuesta ha sido enviada correctamente.');
        } else {
            return redirect()->back()
                           ->with('error', 'Error al enviar la respuesta. Inténtalo de nuevo.')
                           ->withInput();
        }
    }

    public function marcarSolucionado($id)
    {
        $reclamosModel = new ReclamoModel();
        $usuario_id = session()->get('user_id');
        
        // Verificar que el reclamo pertenece al usuario
        $reclamo = $reclamosModel->where('id', $id)
                            ->where('usuario_id', $usuario_id)
                            ->first();
        
        if (!$reclamo) {
            return redirect()->to('../mis-reclamos')
                           ->with('error', 'Reclamo no encontrado o no tienes permisos para modificarlo.');
        }
        
        // Verificar que el estado actual permite marcar como solucionado
        if (!in_array($reclamo['estado'], ['pendiente', 'en_proceso'])) {
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('error', 'Solo puedes marcar como solucionado los reclamos pendientes o en proceso.');
        }
        
        // Actualizar el estado a solucionado
        $datos = [
            'estado' => 'solucionado',
            'fecha_actualizacion' => date('Y-m-d H:i:s')
        ];
        
        // Debug: verificar qué se está guardando
        log_message('debug', 'Intentando actualizar reclamo ID: ' . $id . ' con estado: ' . $datos['estado']);
        
        if ($reclamosModel->update($id, $datos)) {
            // Verificar que se guardó correctamente
            $reclamoActualizado = $reclamosModel->find($id);
            log_message('debug', 'Estado guardado en BD: ' . $reclamoActualizado['estado']);
            
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('success', '¡Excelente! Tu reclamo ha sido marcado como solucionado.');
        } else {
            return redirect()->to('/ciudadano/mis-reclamos')
                           ->with('error', 'Error al actualizar el estado. Inténtalo de nuevo.');
        }
    }

    // Método para mostrar la vista de preguntas frecuentes
    public function preguntas_frecuentes()
    {
        return view('ciudadano/preguntas_frecuentes', [
            'titulo' => 'Preguntas Frecuentes'
        ]);
    }

    public function tramites()
{
    return view('ciudadano/tramites', [
        'titulo' => 'Información sobre Trámites'
    ]);
}

public function perfil()
{
    $usuarioModel = new UsuarioModel();
    $usuario_id = session()->get('user_id') ?? 1;
    
    $usuario = $usuarioModel->find($usuario_id);
    
    return view('ciudadano/perfil', [
        'titulo' => 'Configuración de Perfil',
        'usuario' => $usuario
    ]);
}

public function actualizarPerfil()
{
    $usuarioModel = new UsuarioModel();
    $usuario_id = session()->get('user_id') ?? 1;
    
    $datos = $this->request->getPost();
    
    // Validaciones básicas
    $validationRules = [
        'nombre' => 'required|min_length[3]',
        'apellido' => 'required|min_length[3]',
        'email' => 'required|valid_email',
    ];
    
    if (!$this->validate($validationRules)) {
        return redirect()->back()
                       ->with('error', 'Por favor corrige los errores en el formulario.')
                       ->withInput();
    }
    
    // Actualizar el usuario
    if ($usuarioModel->update($usuario_id, $datos)) {
        return redirect()->back()
                       ->with('success', 'Tu perfil ha sido actualizado exitosamente.');
    } else {
        return redirect()->back()
                       ->with('error', 'Error al actualizar el perfil. Inténtalo de nuevo.')
                       ->withInput();
    }
}

public function cambiarPassword()
{
    $usuarioModel = new UsuarioModel();
    $usuario_id = session()->get('user_id') ?? 1;
    
    $datos = $this->request->getPost();
    
    // Validaciones
    $validationRules = [
        'password_actual' => 'required',
        'nuevo_password' => 'required|min_length[8]',
        'confirmar_password' => 'required|matches[nuevo_password]',
    ];
    
    if (!$this->validate($validationRules)) {
        return redirect()->back()
                       ->with('error', 'Por favor corrige los errores en el formulario.')
                       ->withInput();
    }
    
    // Verificar contraseña actual
    $usuario = $usuarioModel->find($usuario_id);
    if (!password_verify($datos['password_actual'], $usuario['password'])) {
        return redirect()->back()
                       ->with('error', 'La contraseña actual no es correcta.')
                       ->withInput();
    }
    
    // Actualizar contraseña
    $updateData = [
        'password' => password_hash($datos['nuevo_password'], PASSWORD_DEFAULT)
    ];
    
    if ($usuarioModel->update($usuario_id, $updateData)) {
        return redirect()->back()
                       ->with('success', 'Tu contraseña ha sido cambiada exitosamente.');
    } else {
        return redirect()->back()
                       ->with('error', 'Error al cambiar la contraseña. Inténtalo de nuevo.')
                       ->withInput();
    }
}

public function actualizarNotificaciones()
{
    $usuarioModel = new UsuarioModel();
    $usuario_id = session()->get('user_id') ?? 1;

    $datos = $this->request->getPost();
    
    // Preparar datos para actualizar
    $updateData = [
        'notificaciones_email' => isset($datos['notificaciones_email']) ? 1 : 0,
        'notificaciones_sms' => isset($datos['notificaciones_sms']) ? 1 : 0,
        'frecuencia_notificaciones' => $datos['frecuencia_notificaciones']
    ];
    
    if ($usuarioModel->update($usuario_id, $updateData)) {
        return redirect()->back()
                       ->with('success', 'Tus preferencias de notificación han sido actualizadas.');
    } else {
        return redirect()->back()
                       ->with('error', 'Error al actualizar las preferencias. Inténtalo de nuevo.');
    }
}

public function actualizarPreferencias()
{
    $usuarioModel = new UsuarioModel();
    $usuario_id = session()->get('user_id') ?? 1;

    $datos = $this->request->getPost();

    // Solo incluir datos no vacíos
    $updateData = [];
    if (!empty($datos['idioma'])) {
        $updateData['idioma'] = $datos['idioma'];
    }
    if (!empty($datos['tema'])) {
        $updateData['tema'] = $datos['tema'];
    }
    if (!empty($datos['zona_horaria'])) {
        $updateData['zona_horaria'] = $datos['zona_horaria'];
    }

    if (!empty($updateData)) {
        if ($usuarioModel->update($usuario_id, $updateData)) {
            return redirect()->back()
                             ->with('success', 'Tus preferencias del sistema han sido actualizadas.');
        } else {
            return redirect()->back()
                             ->with('error', 'Error al actualizar las preferencias. Inténtalo de nuevo.');
        }
    } else {
        return redirect()->back()
                         ->with('error', 'No se detectaron cambios para actualizar.');
    }
}

}
