<?php

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $noConfirmado = false;
        
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            
            $alertas = $usuario->validarLogin();

            if(empty($alertas)) {
                // Verificar que el usuario exista
                $usuario = Usuario::where('email', $usuario->email);
                
                if(!$usuario){
                    Usuario::setAlerta('error', 'El usuario no existe');
                } elseif($usuario && empty($usuario->confirmado)) {
                    Usuario::setAlerta('error', 'El usuario aún no está confirmado');
                    $noConfirmado = true;
                } else {
                    if(password_verify($_POST['password'], $usuario->password)) {
                        session_start();
                        $_SESSION['id'] = $usuario->id;
                        $_SESSION['nombre'] = $usuario->nombre;
                        $_SESSION['email'] = $usuario->email;
                        $_SESSION['login'] = true;

                        // Redireccionar al proyecto
                        header('Location: /dashboard');
                    } else {
                        Usuario::setAlerta('error', 'Password incorrecto');
                    }
                }     
            }
        }
        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas,
            'noConfirmado' => $noConfirmado
        ]);
    }

    public static function logout() {
        session_start();
        $_SESSION = [];
        header('Location: /');
    }

    public static function crear(Router $router) {

        $usuario = new Usuario;
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

            if(empty($alertas)) {
                $existeUsuario = Usuario::where('email', $usuario->email);
                if($existeUsuario) {
                    Usuario::setAlerta('error', 'El Usuario ya esta registrado');
                    $alertas = Usuario::getAlertas();
                } else {
                    //Hashear Password
                    $usuario->hashPassword();

                    //Eliminar Password2
                    unset($usuario->password2);
                    // Generar Token
                    $usuario->crearToken();
                    // Enviar el email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    //debuguear($email);
                    $email->enviarConfirmacion();
                    // Crear el usuario
                    $resultado = $usuario->guardar();

                    if($resultado){
                        header('Location: /mensaje');
                    }
                }
            }
        }

        //Render a la vista
        $router->render('auth/crear', [
            'titulo' => 'Crear cuenta',
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function olvide(Router $router) {
        $alertas = [];
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado === "1") {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar un email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();
                    // Imprimir una alaerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                    //debuguear($usuario);
                } else {
                    // No encontro el usuario
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/olvide', [
            'titulo' => 'Reiniciar Password',
            'alertas' => $alertas
        ]);
    }

    public static function reestablecer(Router $router) {
        $alertas = [];
        $token = s($_GET['token']);
        $mostrar = true; // Ocultara el formulario si no encuentra el password

        if(!$token) header('Location /');

        // Identificar el usuario con este token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            Usuario::setAlerta('error', 'Token no válido');
            $mostrar = false;
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Añadir el nuevo password
            $usuario->sincronizar($_POST);

            // Validar password
            $alertas = $usuario->validarPassword();

            if(empty($alertas)) {
                // Hashear password
                $usuario->hashPassword();
                //Eliminar token
                $usuario->token = null;
                // Eliminar password 2 del modelo
                unset($usuario->password2);

                // Guardar el password del usuario
                $resultado = $usuario->guardar();

                if($resultado) {
                    header('Location: /');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        //Render a la vista
        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'alertas' => $alertas,
            'mostrar' => $mostrar
        ]);
    }

    public static function mensaje(Router $router) {        
        
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada exitosamente'
        ]);
    }
    public static function reenviar(Router $router) {    
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $alertas = $usuario->validarEmail();

            if(empty($alertas)) {
                $usuario = Usuario::where('email', $usuario->email);

                if($usuario && $usuario->confirmado === "0") {
                    // Generar un nuevo token
                    $usuario->crearToken();
                    unset($usuario->password2);

                    // Actualizar el usuario
                    $usuario->guardar();
                    // Enviar un email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();
                    // Imprimir una alaerta
                    Usuario::setAlerta('exito', 'Hemos enviado las instrucciones a tu email');
                    //debuguear($usuario);
                } else {
                    // No encontro el usuario
                    Usuario::setAlerta('error', 'El usuario no existe.');
                }
            }
        }
        $alertas = Usuario::getAlertas();

        $router->render('auth/reenviar', [
            'titulo' => 'Confirmación enviada',
            'alertas' => $alertas
        ]);
    }

    public static function confirmar(Router $router) {
        $token = s($_GET['token']);
        $alertas = [];
        if(!$token) header('Location: /');

        //Encontrar al usuario con este token
        $usuario = Usuario::where('token', $token);
        
        if(empty($usuario)) {
            //No se encontro el usuario con ese token
            Usuario::setAlerta('error', 'Token no válido');
        } else {
            // Confirmar el usuario
            $usuario->confirmado = 1;
            $usuario->token = null;
            unset($usuario->password2);

            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta validada correctamente');
        }
        $alertas = Usuario::getAlertas();

        //Render a la vista
        $router->render('auth/confirmar', [
            'titulo' => 'Cuenta confirmada',
            'alertas' => $alertas
        ]);

    }
}