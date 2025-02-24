<?php

namespace App\Controllers;
use App\Models\UsuarioModel;
use CodeIgniter\Controller;

class Register extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register()
    {
        $request = service('request');
        $usuarioModel = new UsuarioModel();

        $email = $request->getPost('email');
        $usuario = $request->getPost('usuario');
        $password = $request->getPost('password');

        // Verificar si los campos están vacíos
        if (!$email || !$usuario || !$password) {
            return redirect()->back()->with('error', 'Todos los campos son obligatorios.');
        }

        // Comprobar si el email o usuario ya existen
        $existeUsuario = $usuarioModel->where('email', $email)->orWhere('usuario', $usuario)->first();
        if ($existeUsuario) {
            return redirect()->back()->with('error', 'Nombre de usuario o Gmail ya en uso.');
        }

        // Validar seguridad de la contraseña
        if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_]).{8,}$/', $password)) {
            return redirect()->back()->with('error', 'La contraseña debe tener al menos 8 caracteres, una mayúscula y un símbolo.');
        }

        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insertar en la base de datos
        $usuarioModel->insert([
            'email' => $email,
            'usuario' => $usuario,
            'password' => $hashedPassword
        ]);

        // Guardar mensaje de éxito y redirigir a login
        session()->setFlashdata('success', 'Registro exitoso. Ahora puedes iniciar sesión.');
        return redirect()->to(base_url('/login'));
        
    }
}
