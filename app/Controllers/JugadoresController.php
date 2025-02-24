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
        $file = $this->request->getFile('imagen');

        // Verificar si el jugador ya existe
        $nombreJugador = $this->request->getPost('nombre');
        $jugadorExistente = $jugadorModel->where('nombre', $nombreJugador)->first(); // Verifica si el jugador ya está registrado

        if ($jugadorExistente) {
            return redirect()->back()->with('error', 'El jugador ya está registrado en la base de datos.');
        }

        // Verificar si se recibió una imagen
        if (!$file) {
            return redirect()->back()->with('error', 'No se recibió ninguna imagen.');
        }

        // Subir imagen si es válida
        if ($file->isValid() && !$file->hasMoved()) {
            $nombreArchivo = $file->getRandomName();
            $file->move(FCPATH . 'uploads/jugadores', $nombreArchivo);

            // Verificar si la imagen se movió correctamente
            if (!$file->hasMoved()) {
                return redirect()->back()->with('error', 'Error al mover la imagen.');
            }

            // Insertar el jugador en la base de datos
            $data = [
                'nombre' => $this->request->getPost('nombre'),
                'nacionalidad' => $this->request->getPost('nacionalidad'),
                'posicion' => $this->request->getPost('posicion'),
                'equipo_actual' => $this->request->getPost('equipo_actual'),
                'estado' => $this->request->getPost('estado'),
                'imagen' => $nombreArchivo
            ];

            $jugadorModel->insert($data);

            return redirect()->to('/subir')->with('success', 'Jugador agregado correctamente.');
        }
        

        return redirect()->back()->with('error', 'Error al subir la imagen.');
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
            ->select('nombre, nacionalidad, posicion, imagen')
            ->where('estado', 'retirado') // ✅ Solo jugadores retirados
            ->like('LOWER(nombre)', strtolower($nombre), 'both')
            ->distinct()
            ->findAll();
    
        foreach ($resultados as &$jugador) {
            // ✅ Ruta corregida sin "public/"
            if (!empty($jugador['imagen']) && file_exists(FCPATH . 'uploads/jugadores/' . $jugador['imagen'])) {
                $jugador['imagen'] = base_url('uploads/jugadores/' . $jugador['imagen']);
            } else {
                $jugador['imagen'] = base_url('uploads/jugadores/default.jpg'); // ✅ Imagen por defecto
            }
        }
    
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
        ->select('nombre, nacionalidad, posicion, imagen')
        ->where('estado', 'actual') // ✅ Solo jugadores activos
        ->like('LOWER(nombre)', strtolower($nombre), 'both')
        ->distinct()
        ->findAll();

    foreach ($resultados as &$jugador) {
        // ✅ Verifica si la imagen existe y genera la URL correcta
        if (!empty($jugador['imagen']) && file_exists(FCPATH . 'uploads/jugadores/' . $jugador['imagen'])) {
            $jugador['imagen'] = base_url('uploads/jugadores/' . $jugador['imagen']);
        } else {
            $jugador['imagen'] = base_url('uploads/jugadores/default.jpg'); // ✅ Imagen por defecto
        }
    }

    return $this->response->setJSON($resultados);
}

}
