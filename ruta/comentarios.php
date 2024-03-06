<?php

header('Content-Type: application/json');

require_once $_SERVER["DOCUMENT_ROOT"] . "/controlador/comentariosControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/autenticacion/token_seguridad.php";

$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener la ruta de la solicitud
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';

$ruta = strtolower($ruta);

$comentariosControlador = new ComentariosControlador();
$autenticacionJWT = new AutenticacionJWT();

// Manejar la solicitud según el método y la ruta

switch ($metodo) {

    case 'POST':
        switch ($ruta) {
            case 'registrar':

                $autenticacion = $autenticacionJWT->verificacion_token();

                if (is_array($autenticacion) && array_key_exists("error", $autenticacion)) {

                    echo json_encode(array("error" => $autenticacion['error'], "mensaje" => $autenticacion['mensaje']));

                } else {

                    $cuerpo_comentario = file_get_contents('php://input');
                    $comentario = json_decode($cuerpo_comentario, true);

                    error_log(json_encode("router" . $autenticacion->usuario_id));

                    echo $comentariosControlador->registrarComentario($autenticacion->usuario_id, $comentario);
                }

                break;
            default:

                echo json_encode(array("error" => "Ruta POST no válida"));
                break;
        }
        break;
    default:
        echo json_encode(array("error" => "Método no permitido"));
        break;
}


