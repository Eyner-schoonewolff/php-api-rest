<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/conexion/database.php';

session_start();

class ModeloNoticiasUsuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }


    public function obtenerNoticiasUsuario($id)
    {
        try {
            $query = "SELECT * FROM noticias WHERE estado = 1 AND id_usuario = '$id';";

            $resultados = $this->conexion->query($query);

            // Obtener todas las filas como un array asociativo de arrays
            $usuarios = mysqli_fetch_all($resultados, MYSQLI_ASSOC);

            $this->conexion->cerrarConexion();
            // Devolver los usuarios como JSON
            return json_encode($usuarios);

        } catch (Exception $e) {
            // Manejar la excepción
            return json_encode(array("error" => $e->getMessage()));
        }
    }



    public function actualizarNoticia($id_usuario, $noticia)
    {
        try {

            $id_noticia = $noticia["id_noticia"];

            $query = "UPDATE noticias SET titulo = '$noticia[titulo]', descripcion = '$noticia[descripcion]' WHERE id = '$id_noticia' AND id_usuario = '$id_usuario';";

            $noticiaActualizar = $this->conexion->query($query);

            $this->conexion->cerrarConexion();

            if ($noticiaActualizar) {
                http_response_code(200);
                return json_encode(array("id" => $id_noticia, "mensaje" => "noticia actualizada correctamente."));
            }

            http_response_code(500);
            return json_encode(array("error" => "No se pudo actualizar la noticia del Usuario."));

        } catch (Exception $e) {
            // Manejar la excepción
            return json_encode(array("error" => $e->getMessage()));
        }


    }


    public function registrarNoticia($id_usuario, $noticia)
    {
        try {


            $query = "INSERT INTO noticias (id_usuario,titulo, descripcion) VALUES ('$id_usuario','$noticia[titulo]','$noticia[descripcion]')";

            $resultados = $this->conexion->query($query);

            if ($resultados) {

                $id_noticia = $this->conexion->obtner_id();
                
                $this->conexion->cerrarConexion();

                http_response_code(202);
                return json_encode(array("id_noticia" => $id_noticia, "id_usuario" => $id_usuario, "mensaje" => "Noticia registrada exitosamente."));
            } else {
                throw new Exception("Error al registrar usuario");
            }
        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }


    }

    public function actualizarEstadoNoticia($id_usuario, $noticia)
    {
        try {

            // error_log(json_encode($id));

            $estado = $noticia["estado"];
            $id_noticia = $noticia["id_noticia"];


            $query = "UPDATE noticias SET estado = '$estado' WHERE id = '$id_noticia' AND id_usuario = '$id_usuario';";

            $resultados = $this->conexion->query($query);

            $this->conexion->cerrarConexion();

            if ($resultados) {

                $mensaje = $resultados ? ($estado == 1 ? "Noticia activado correctamente." : ($estado == 0 ? "Noticia desactivado correctamente." : "Estado de la Noticia actualizado correctamente.")) : "No se pudo actualizar la Noticia";
                return json_encode($resultados ? array("id" => $id_noticia, "mensaje" => $mensaje) : array("error" => $mensaje));
            }

            return json_encode(array("error" => "No se pudo actualizar la Noticia."));

        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }

    }



    // Otros métodos para actualizar, obtener un usuario específico, etc.
}

