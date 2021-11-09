<?php

namespace Controllers;

use Model\Proyecto;
use MVC\Router;

class DashboardController {
    public static function index(Router $router) {
        session_start();
        isAuth();

        $id = $_SESSION['id'];
        $proyectos = Proyecto::belongsTo('propietarioId', $id);
        $year = date('Y');   

        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos,
            'year' => $year,
        ]);
    }
    public static function crear_proyecto(Router $router) {
        session_start();
        isAuth();
        $alertas = [];
        $year = date('Y');

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proyecto = new Proyecto($_POST);

            // Validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                // Generar una url única
                $hash = md5(uniqid());
                $proyecto->url = $hash;
                // Obtener fecha de creación
                $proyecto->fecha = date('Y-m-d');
                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];
                // Guardar el proyecto
                $proyecto->guardar();
                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url);        
            }
        }

        $router->render('dashboard/crear-proyecto', [
            'titulo' => 'Crear Proyecto',
            'alertas' => $alertas,
            'year' => $year
        ]);
    }

    public static function proyecto(Router $router) {
        session_start();
        isAuth();
        $year = date('Y');
        
        $token = $_GET['id'];
        if(!$token) {
            header('Location: /dashboard');
        }
        // Revisar que la persona que visita el proyecto, es quien lo Creo
        $proyecto = Proyecto::where('url', $token);
        if($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }

        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto,
            'year' => $year,
        ]);
    }

    public static function perfil(Router $router) {
        session_start();
        isAuth();
        $year = date('Y');

        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'year' => $year
        ]);
    }
}