<?php

namespace App\Models;

use CodeIgniter\Model;

class JugadorModel extends Model
{
    protected $table = 'jugadores';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'nacionalidad', 'posicion', 'equipo_actual', 'estado', 'fecha_de_nacimiento'];
}
