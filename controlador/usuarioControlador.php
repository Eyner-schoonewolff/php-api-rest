<?php

require_once $_SERVER["DOCUMENT_ROOT"] . '/modelo/usuarios.php';

class UsuarioControlador
{

    private $modeloUsuario;

    public function __construct()
    {
        $this->modeloUsuario = new ModeloUsuario();
    }


    function registrarUsuario($usuario)
    {
        try {

            if ($usuario === null) {
                // La decodificación falló
                http_response_code(500);
                return json_encode(array("error" => "Error al decodificar el JSON"));
            }

            $contrasenia_encriptadata = $this->encriptar_clave($usuario["contrasenia"]);

            $datosUsuario = array(
                "nombre" => $usuario["nombre"],
                "correo" => $usuario["correo"],
                "contrasenia" => $contrasenia_encriptadata,
                "direccion" => $usuario["direccion"],
                "telefono" => $usuario["telefono"],
                "fecha_nacimiento" => $usuario["fecha_nacimiento"],
            );

            $resultado = $this->modeloUsuario->agregarUsuario($datosUsuario);

            return $resultado;


        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }
    }

    private function encriptar_clave($contrasenia)
    {
        $encriptacion_contrasenia = hash('sha256', $contrasenia);;
        return $encriptacion_contrasenia;

    }

    public function autenticarUsuario($usuario)
    {
        try {

            // Verificar si la decodificación fue exitosa
            if ($usuario === null) {

                http_response_code(500);
                return json_encode(array("error" => "Error al decodificar el JSON"));

            } else {

                $autenticacionUsuario = array(
                    "correo" => $usuario["correo"],
                    "contrasenia" => $this->encriptar_clave($usuario["contrasenia"]),
                );

                $resultado = $this->modeloUsuario->verificacionUsuario($autenticacionUsuario);

                return $resultado;
            }


        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));
        }
    }


}