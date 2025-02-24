<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'usuario', 'password', 'created_at'];

    public function verificarCredenciales($email, $password)
    {
        $usuario = $this->where('email', $email)->first();

        if ($usuario && password_verify($password, $usuario['password'])) {
            return $usuario;
        }
        return false;
    }

    public function getUserById($id)
    {
        return $this->where('id', $id)->first();
    }
}
