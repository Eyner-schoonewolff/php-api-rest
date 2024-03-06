<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/conexion/database.php';
class ModeloComentarios
{

    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }

    public function registrarComentariosNoticia($id_usuario, $informacion_comentario)
    {
        try {

            $this->conexion->begin_transaction();

            $query = "INSERT INTO comentarios (comentario) 
                    VALUES ('$informacion_comentario[comentario]')";

            $respuesta_comentario = $this->conexion->query($query);

            if ($respuesta_comentario) {
                $id_comentario = $this->conexion->obtner_id();

                error_log(json_encode($id_usuario));
                
                $this->conexion->guardar_cambios();

                $this->registrarUsuarioComentarios($id_usuario, $informacion_comentario['id_noticia'], $id_comentario);

                http_response_code(202);

                return json_encode(array("id_usuario" => $id_usuario, "id_comentario" => $id_comentario, "mensaje" => "Comentario registrada exitosamente."));

            } else {
                throw new Exception("Error al registrar usuario");
            }
        } catch (Exception $e) {
            $this->conexion->retroceder();
            return json_encode(array("error" => $e->getMessage()));
        }

    }

    public function registrarUsuarioComentarios($id_usuario, $id_noticia, $id_comentario)
    {
        try {

            $query = "INSERT INTO usuario_comentarios (id_usuario,id_noticia,id_comentario) 
            VALUES ('$id_usuario','$id_noticia','$id_comentario')";

            $this->conexion->query($query);

            $this->conexion->guardar_cambios();
            $this->conexion->cerrarConexion();


        } catch (Exception $e) {
            $this->conexion->retroceder();
        }

    }



}