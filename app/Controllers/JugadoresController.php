<?php

namespace App\Controllers;

use App\Models\JugadorModel;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

class JugadoresController extends ResourceController
{
    public function subirImagen()
    {
        $jugadorModel = new JugadorModel();

        // Verificar si el jugador ya existe
        $nombreJugador = $this->request->getPost('nombre');
        $jugadorExistente = $jugadorModel->where('nombre', $nombreJugador)->first();

        if ($jugadorExistente) {
            return redirect()->back()->with('error', 'El jugador ya está registrado en la base de datos.');
        }

        // Insertar el jugador en la base de datos
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'nacionalidad' => $this->request->getPost('nacionalidad'),
            'posicion' => $this->request->getPost('posicion'),
            'equipo_actual' => $this->request->getPost('equipo_actual'),
            'estado' => $this->request->getPost('estado'),
            'fecha_de_nacimiento' => $this->request->getPost('fecha_de_nacimiento')
        ];

        $jugadorModel->insert($data);

        return redirect()->to('/subir')->with('success', 'Jugador agregado correctamente.');
    }

    public function retirados(){
        return view('seleccion-jugadores1');
    }

    public function buscarJugadoresRetirados()
    {
        $nombre = $this->request->getGet('nombre');
    
        if (!$nombre) {
            return $this->response->setJSON([]);
        }
    
        $jugadorModel = new JugadorModel();
        $resultados = $jugadorModel
            ->select('nombre, nacionalidad, posicion, fecha_de_nacimiento') // Eliminada la imagen, añadida la fecha de nacimiento
            ->where('estado', 'retirado') // ✅ Solo jugadores retirados
            ->like('LOWER(nombre)', strtolower($nombre), 'both')
            ->distinct()
            ->findAll();
    
        return $this->response->setJSON($resultados);
    }
    
    


    public function actuales(){
        return view('seleccion-jugadores2');
    }

    public function buscarJugadoresActuales()
    {
        $nombre = $this->request->getGet('nombre');
    
        if (!$nombre) {
            return $this->response->setJSON([]);
        }
    
        $jugadorModel = new JugadorModel();
        $resultados = $jugadorModel
            ->select('nombre, nacionalidad, posicion, fecha_de_nacimiento') // Eliminada la imagen, añadida la fecha de nacimiento
            ->where('estado', 'actual') // ✅ Solo jugadores actuales
            ->like('LOWER(nombre)', strtolower($nombre), 'both')
            ->distinct()
            ->findAll();
    
        return $this->response->setJSON($resultados);
    }
    

}
