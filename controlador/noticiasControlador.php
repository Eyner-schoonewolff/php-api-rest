<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/modelo/noticias.php';


class NoticiasControlador
{

    private $noticiaModelo;

    public function __construct()
    {
        $this->noticiaModelo = new ModeloNoticiasUsuario();

    }


    function registroNoticias($id_usuario, $noticia)
    {
        try {

            // Verificar si la decodificación fue exitosa
            if ($noticia === null) {
                // La decodificación falló
                http_response_code(500);
                return json_encode(array("error" => "Error al decodificar el JSON"));

            }

            $informacionComentario = array(
                "titulo" => $noticia["titulo"],
                "descripcion" => $noticia["descripcion"],
            );

            // error_log(json_encode($id_usuario));
            $respuesta_noticia = $this->noticiaModelo->registrarNoticia($id_usuario, $informacionComentario);
            return $respuesta_noticia;

        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    public function obtenerNoticiasUsuario($id_usuario)
    {
        try {
            // este metodo se para obtener las noticias por usuario, es decir del usuario que este actualmente en la session
            // se obtendra el id y se realizara el respectivo filtro
            $usuario = $this->noticiaModelo->obtenerNoticiasUsuario($id_usuario);
            $usuario = json_decode($usuario, true);
            return empty($usuario) ? json_encode(array("mensaje" => "No se encuentran noticias disponibles")) : json_encode($usuario);

        } catch (Exception $e) {

        }
    }

    public function actualizar($id_usuario, $noticia)
    {
        try {

            $id_noticia = $noticia["id_noticia"];
            $noticia_info = $noticia["datos"];

            error_log(json_encode($noticia_info));

            if ($id_noticia === null) {
                http_response_code(404);
                return json_encode(array("error" => "No se proporcionó el id de la noticia, por favor verificar."));
            }

            if ($noticia_info === null) {
                http_response_code(404);
                return json_encode(array("error" => "Error al decodificar el JSON"));
            }

            $noticia = array("id_noticia" => $id_noticia, "titulo" => $noticia_info["titulo"], "descripcion" => $noticia_info["descripcion"]);
            $actualizacion = $this->noticiaModelo->actualizarNoticia($id_usuario, $noticia);

            return $actualizacion;

        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));

        }
    }

    function actualizarEstado($id_usuario, $noticia)
    {

        try {

            $id_noticia = $noticia['id_noticia'];

            if ($id_noticia === null) {

                http_response_code(404);
                return json_encode(array("error" => "No se proporcionó un ID"));
            }

            if ($noticia === null) {
                http_response_code(404);
                return json_encode(array("error" => "Error al decodificar el JSON"));

            }

            $actualizacion = $this->noticiaModelo->actualizarEstadoNoticia($id_usuario, $noticia);

            return $actualizacion;

        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));

        }



    }
}