<?php

header('Content-Type: application/json');

require_once "./controlador/usuarioControlador.php";

$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener la ruta de la solicitud
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';

$ruta = strtolower($ruta);

$usuarioControlador = new UsuarioControlador();


switch ($metodo) {

    case 'POST':
        switch ($ruta) {
            case 'autenticacion/usuario':

                $cuerpo_usuario = file_get_contents('php://input');
                $usuario = json_decode($cuerpo_usuario, true);

                echo $usuarioControlador->autenticarUsuario($usuario);

                break;
            case 'registrar/usuario':
                $cuerpo_usuario = file_get_contents('php://input');
                $usuario_registro = json_decode($cuerpo_usuario, true);

                echo $usuarioControlador->registrarUsuario($usuario_registro);

                break;
            default:
                // Ruta no válida para el método POST
                echo json_encode(array("error" => "Ruta POST no válida"));
                break;
        }
        break;

    default:
        echo json_encode(array("error" => "Método no permitido"));
        break;
}