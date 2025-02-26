<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

class EquiposController extends ResourceController
{
    public function vistaSeleccion()
{
    return view('seleccion-equipos');
}

public function subirImagen()
    {
        $equipoModel = new EquipoModel();

        // Verificar si el equipo ya existe
        $nombreEquipo = $this->request->getPost('nombre');
        $equipoExistente = $equipoModel->where('nombre', $nombreEquipo)->first();

        if ($equipoExistente) {
            return redirect()->back()->with('error', 'El equipo ya está registrado en la base de datos.');
        }

        // Insertar el equipo en la base de datos
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'pais' => $this->request->getPost('pais'),
            'liga' => $this->request->getPost('liga')
        ];

        $equipoModel->insert($data);

        return redirect()->to('/subir')->with('success', 'Equipo agregado correctamente.');
    }

    public function buscarEquipos()
{
    $nombre = $this->request->getGet('nombre');

    if (!$nombre) {
        return $this->response->setJSON([]);
    }

    $equipoModel = new EquipoModel();
    $resultados = $equipoModel
        ->select('nombre, pais') // Eliminado el campo imagen
        ->like('LOWER(nombre)', strtolower($nombre), 'both')
        ->distinct()
        ->findAll();

    return $this->response->setJSON($resultados);
}
   
    public function juego(){
        return view('juego');
    }
}
