<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\RESTful\ResourceController;

class JuegoLocalController extends ResourceController
{
    public function seleccionarEquipo()
    {
        $equipoModel = new EquipoModel();
        $equipo = $equipoModel->orderBy('id', 'RANDOM')->first(); // Forzar selección aleatoria
        
        if ($equipo) {
            return $this->response->setJSON([
                'nombre' => $equipo['nombre'],
                'pais'   => $equipo['pais'],
                'liga'   => $equipo['liga'],
                'imagen' => base_url('uploads/equipos/' . $equipo['imagen'])
            ]);
        } else {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'No se encontró ningún equipo']);
        }
    }
    
    public function iniciarJuego() {
        return view('IniciarJuego');  // Redirige a la vista del juego
    }
    
    

}
