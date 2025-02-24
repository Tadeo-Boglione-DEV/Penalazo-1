<?php

namespace App\Controllers;

use App\Models\UsuarioModel;

class PerfilController extends BaseController
{
    public function index()
    {
        $session = session();
        $userId = $session->get('id'); // ID del usuario en sesión
    
        if (!$userId) {
            return redirect()->to('/login'); // Redirige al login si no hay sesión activa
        }
    
        $userModel = new UsuarioModel();
        $usuario = $userModel->getUserById($userId);
    
        return view('perfil', ['usuario' => $usuario]);
    }
    
}
