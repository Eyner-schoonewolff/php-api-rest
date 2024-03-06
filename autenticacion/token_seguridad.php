<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AutenticacionJWT
{
    private $llave_secreta;
    private $token;
    public function __construct()
    {
        $dotenv = Dotenv\Dotenv::createImmutable($_SERVER["DOCUMENT_ROOT"] . '/config');
        $dotenv->load();

        $this->llave_secreta = $_ENV['SECRET_KEY'];

        $headers = apache_request_headers();
        $this->token = isset($headers['Authorization']) ? $headers['Authorization'] : null;
    }


    function generarTokenJWT($usuario)
    {
        // Crear el payload del token con la información del usuario
        $payload = array(
            "usuario_id" => $usuario['id'],
            "exp" => time() + 3600 // El token expira en 1 hora (3600 segundos)
        );

        // Generar el token JWT con la clave secreta y el algoritmo
        $token = JWT::encode($payload, $this->llave_secreta, 'HS256');

        return $token;
    }


    public function verificacion_token()
    {
        if ($this->token) {
            $autenticacion = str_replace("Bearer", "", $this->token);

            try {
                $decoded = JWT::decode($autenticacion, new Key($this->llave_secreta, 'HS256'));
                return $decoded;

            } catch (Exception $e) {
                return array("error" => "Acceso denegado. Token inválido.", "mensaje" => $e->getMessage());
            }
        }

        return array("error" => "Acceso denegado. Token no proporcionado.", "mensaje" => "Permisos denegados.");
    }










}