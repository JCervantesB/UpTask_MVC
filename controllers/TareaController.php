<?php

namespace Controllers;

use Model\Proyecto;
use Model\Tarea;

class TareaController {
    public static function index() {

        $proyectoId = $_GET['id'];        

        if(!$proyectoId) header('Location: /dashboard');  

        $proyecto = Proyecto::where('url', $proyectoId);

        session_start();
        if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) header('Location: /404');

        $tareas = Tarea::belongsTo('proyectoId', $proyecto->id);

        // Contar total de Tareas
        $totalTareas = count($tareas);
        // Contar Tareas Pendientes
        
        // Contar Tareas completadas
        debuguear($tareas);
    }

    public static function crear() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $proyectoId = $_POST['proyectoId'];
            $proyecto = Proyecto::where('url', $proyectoId);

            if(!$proyecto || $proyecto->propietarioId !== $_SESSION['id']) {
                $repuesta = [
                    'tipo' => 'error',
                    'mensaje' => 'Hubo un Error al agregar la tarea'
                ];
                echo json_encode($repuesta);    
                return;            
            } 
            // Todo bien, Instanciar y crear la Tarea
            $tarea = new Tarea($_POST);
            $tarea->proyectoId = $proyecto->id;
            $resultado = $tarea->guardar();
            $respuesta = [
                'tipo' => 'exito',
                'id' => $resultado['id'],
                'mensaje' => 'Tarea Creada Correctamente'
            ];
            echo json_encode($respuesta);
           
        }
    }

    public static function actualizar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }

    public static function eliminar() {
        if($_SERVER['REQUEST_METHOD'] === 'POST') {

        }
    }
    
}