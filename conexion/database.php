<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/vendor/autoload.php';

class Conexion
{
    private $conexion;

    public function __construct()
    {
        // Cargar variables de entorno desde el archivo .env
        $dotenv = Dotenv\Dotenv::createImmutable($_SERVER["DOCUMENT_ROOT"] . '/config');
        $dotenv->load();

        // Establecer la conexión con la base de datos
        $this->conexion = new mysqli(
            $_ENV['DB_HOST'],
            $_ENV['DB_USERNAME'],
            $_ENV['DB_PASSWORD'],
            $_ENV['DB_NAME'],
            $_ENV['DB_PORT']
        );

        // Verificar si hay errores en la conexión
        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }

        // Establecer el conjunto de caracteres a UTF-8
        $this->conexion->set_charset("utf8");
    }

    // Método para obtener la conexión
    public function obtenerConexion()
    {
        return $this->conexion;
    }

    public function query($consulta)
    {
        try {
            $resultado = $this->conexion->query($consulta);

            if (!$resultado) {
                die('Error en la consulta: ' . $this->conexion->error);
            }

            return $resultado;

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    // Método para cerrar la conexión
    public function cerrarConexion()
    {
        $this->conexion->close();
    }

    function obtner_id()
    {
        return $this->conexion->insert_id;
    }

    function begin_transaction()
    {
        return $this->conexion->begin_transaction();
    }
    function retroceder()
    {
        return $this->conexion->rollback();
    }
    function guardar_cambios()
    {
        return $this->conexion->commit();
    }
}