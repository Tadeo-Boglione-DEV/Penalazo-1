<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\Controller;

class EquiposController extends BaseController
{
    public function subirImagen()
    {
        $equipoModel = new EquipoModel();
        $file = $this->request->getFile('imagen');

        // Verificar si el equipo ya existe
        $nombreEquipo = $this->request->getPost('nombre');
        $equipoExistente = $equipoModel->where('nombre', $nombreEquipo)->first(); // Verifica si el equipo ya está registrado

        if ($equipoExistente) {
            return redirect()->back()->with('error', 'El equipo ya está registrado en la base de datos.');
        }

        // Verificar si se recibió una imagen
        if (!$file) {
            return redirect()->back()->with('error', 'No se recibió ninguna imagen.');
        }

        // Subir imagen si es válida
        if ($file->isValid() && !$file->hasMoved()) {
            $nombreArchivo = $file->getRandomName();
            $file->move(FCPATH . 'uploads/equipos', $nombreArchivo);

            // Verificar si la imagen se movió correctamente
            if (!$file->hasMoved()) {
                return redirect()->back()->with('error', 'Error al mover la imagen.');
            }

            // Insertar el equipo en la base de datos
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'pais' => $this->request->getPost('pais'),
                'liga' => $this->request->getPost('liga'),
                'imagen' => $nombreArchivo
            ];

            if ($equipoModel->insert($data)) {
                return redirect()->to('/subir')->with('success', 'Equipo agregado correctamente.');
            } else {
                return redirect()->to('/subir')->with('error', 'Error al guardar el equipo en la base de datos.');
            }
        }

        

        return redirect()->back()->with('error', 'Error al subir la imagen.');
    }
}
