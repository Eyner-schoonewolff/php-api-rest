<?php

header('Content-Type: application/json');

require_once "./controlador/noticiasControlador.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/autenticacion/token_seguridad.php";

// Obtener el método de la solicitud HTTP
$metodo = $_SERVER['REQUEST_METHOD'];

// Obtener la ruta de la solicitud
$ruta = isset($_GET['ruta']) ? $_GET['ruta'] : '';

// Convertir la ruta a minúsculas para evitar problemas de mayúsculas y minúsculas
$ruta = strtolower($ruta);

$autenticacionJWT = new AutenticacionJWT();

$noticiasControlador = new NoticiasControlador();

// Manejar la solicitud según el método y la ruta

switch ($metodo) {


    case 'GET':
        switch ($ruta) {
            case 'noticias':
                
                $autenticacion = $autenticacionJWT->verificacion_token();

                if (is_array($autenticacion) && array_key_exists("error", $autenticacion)) {

                    echo json_encode(array("error" => $autenticacion['error'], "mensaje" => $autenticacion['mensaje']));

                } else {
                    echo $noticiasControlador->obtenerNoticiasUsuario($autenticacion->usuario_id);
                }

                break;
            default:
                // Ruta no válida para el método GET
                echo json_encode(array("error" => "Ruta GET no válida"));
                break;
        }
        break;
    case 'POST':
        switch ($ruta) {
            case 'registrar':

                $autenticacion = $autenticacionJWT->verificacion_token();

                if (is_array($autenticacion) && array_key_exists('error', $autenticacion)) {

                    echo json_encode(array("error" => $autenticacion['error'], "mensaje" => $autenticacion['mensaje']));

                } else {

                    $cuerpo_registro = file_get_contents('php://input');
                    $noticia = json_decode($cuerpo_registro, true);

                    echo $noticiasControlador->registroNoticias($autenticacion->usuario_id, $noticia);
                }

                break;
            default:
                // Ruta no válida para el método POST
                echo json_encode(array("error" => "Ruta POST no válida"));
                break;
        }
        break;
    case 'PUT':
        switch ($ruta) {
            case "actualizar":


                $autenticacion = $autenticacionJWT->verificacion_token();

                if (is_array($autenticacion) && array_key_exists('error', $autenticacion)) {

                    echo json_encode(array("error" => $autenticacion['error'], "mensaje" => $autenticacion['mensaje']));

                } else {

                    $cuerpo = file_get_contents("php://input");
                    $informacion_actualizar_noticia = json_decode($cuerpo, true);

                    $id_noticia = isset($_GET['id-noticia']) ? $_GET['id-noticia'] : null;

                    $cuerpo_noticia = array("datos" => $informacion_actualizar_noticia, "id_noticia" => $id_noticia);

                    echo $noticiasControlador->actualizar($autenticacion->usuario_id, $cuerpo_noticia);
                }

                break;

            case "actualizacion/estado":
                
                $autenticacion = $autenticacionJWT->verificacion_token();


                if (is_array($autenticacion) && array_key_exists('error', $autenticacion)) {

                    echo json_encode(array("error" => $autenticacion['error'], "mensaje" => $autenticacion['mensaje']));

                } else {
                    // id de la noticia que se encuentra logueado actualmente en la session
                    $id_noticia = isset($_GET['id_noticia']) ? $_GET['id_noticia'] : null;

                    $cuerpo_noticia = file_get_contents("php://input");
                    $noticia_estado = json_decode($cuerpo_noticia, true);

                    $noticia = array("estado" => $noticia_estado["estado"], "id_noticia" => $id_noticia);

                    echo $noticiasControlador->actualizarEstado($autenticacion->usuario_id, $noticia);
                }

                break;
            default:
                echo json_encode(array("error" => "Ruta PUT no válida"));
                break;

        }
        break;
    default:
        echo json_encode(array("error" => "Método no permitido"));
        break;
}


