<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/modelo/comentarios.php';
class ComentariosControlador
{


    private $modeloComentarios;

    public function __construct()
    {
        $this->modeloComentarios = new ModeloComentarios();
    }


    public function registrarComentario($id_usuario, $comentarios)
    {
        try {

            error_log(json_encode("controlador" . $id_usuario));


            if ($comentarios === null) {
                http_response_code(500);
                return json_encode(array("error" => "Error al decodificar el JSON"));
            }

            $informacionComentario = array(
                "id_noticia" => $comentarios["id_noticia"],
                "comentario" => $comentarios["comentario"],
            );

            $comentario = $this->modeloComentarios->registrarComentariosNoticia($id_usuario, $informacionComentario);

            return $comentario;


        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }
    }
}