<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class AuthController extends Controller
{
    public function logout()
    {
        // Destruir la sesión
        session()->destroy();
        
        // Redirigir a la página principal (home)
        return redirect()->to(base_url('/home'));
    }
}
