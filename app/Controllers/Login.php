<?php

namespace App\Controllers;
use App\Models\UsuarioModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function autenticar()
    {
        $request = service('request');
        $usuarioModel = new UsuarioModel();
        $session = session();

        $email = $request->getPost('email');
        $password = $request->getPost('password');

        if (!$email || !$password) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        $usuario = $usuarioModel->verificarCredenciales($email, $password);

        if ($usuario) {
            // Guardamos tanto el ID como el nombre de usuario en la sesión
            $session->set([
                'id'       => $usuario['id'],  // ID del usuario
                'usuario'  => $usuario['usuario'], // Nombre de usuario
                'email'    => $usuario['email'],
                'logged_in' => true
            ]);

            return redirect()->to(base_url('/home')); // Redirigir a home
        } else {
            return redirect()->back()->with('error', 'Credenciales Incorrectas.');
        }
    }  

    public function logout()
    {
        session()->destroy(); // Destruir la sesión al cerrar sesión
        return redirect()->to('/login');
    }
}
