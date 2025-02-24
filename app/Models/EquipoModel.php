<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    protected $table = 'equipos';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'pais', 'liga', 'imagen'];

    public function getRandomEquipo()
    {
        return $this->db->query("SELECT * FROM equipos ORDER BY RAND() LIMIT 1")->getRowArray();
    }
}
