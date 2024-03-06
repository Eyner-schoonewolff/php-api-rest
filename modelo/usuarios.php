<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/conexion/database.php';
require_once $_SERVER["DOCUMENT_ROOT"] . "/autenticacion/token_seguridad.php";



class ModeloUsuario
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new Conexion();
    }


    public function verificacionUsuario($usuarioAuntenticacion)
    {
        try {

            $correo = $usuarioAuntenticacion["correo"];
            $contrasenia = $usuarioAuntenticacion["contrasenia"];

            $usuario = $this->obtenerUsuario($correo, $contrasenia);

            if ($usuario === null || ($correo === null || $contrasenia === null)) {
                return json_encode(array("login" => false, "mensaje" => "El correo y/o contraseña son incorrectas por favor verificar las credenciales."));
            }

            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $autenticacionJWT = new AutenticacionJWT();

            $token = $autenticacionJWT->generarTokenJWT($usuario);


            return json_encode(array("login" => true, "mensaje" => "Usuario logueado correctamente.", "usuario" => $usuario, "token" => $token));


        } catch (Exception $e) {
            return json_encode(array("error" => $e->getMessage()));

        }
    }

    function obtenerUsuario($correo, $contrasenia)
    {
        try {
            // Obtener la contraseña almacenada en la base de datos para el usuario dado
            $query = "SELECT * FROM usuario WHERE correo = '$correo' AND contrasenia = '$contrasenia'";
            $usuario = $this->conexion->query($query);

            // Verificar si se encontró un usuario con el correo dado
            if ($usuario->num_rows > 0) {
                // Obtener la fila del usuario
                return $usuario->fetch_assoc();
            }

            return null;
        } catch (Exception $e) {
            return null;
        }
    }


    public function agregarUsuario($usuario)
    {
        try {

            $query = "INSERT INTO usuario (nombre, correo, contrasenia, direccion, telefono, fecha_nacimiento) 
            VALUES ('$usuario[nombre]', '$usuario[correo]', '$usuario[contrasenia]', '$usuario[direccion]', '$usuario[telefono]', '$usuario[fecha_nacimiento]');";

            $resultados = $this->conexion->query($query);


            if ($resultados) {
                $id_insertado = $this->conexion->obtner_id();
                $this->conexion->cerrarConexion();

                http_response_code(202);
                return json_encode(array("id" => $id_insertado, "mensaje" => "Usuario registrado exitosamente"));
            } else {
                throw new Exception("Error al registrar usuario");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
            return json_encode(array("error" => $e->getMessage()));
        }


    }

}

