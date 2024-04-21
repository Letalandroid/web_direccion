<?php

namespace Letalandroid\model;

use PDO;
use Exception;

if (file_exists(__DIR__ . '/../../.env')) {
    $env = parse_ini_file(__DIR__ . '/../../.env');
    foreach ($env as $key => $value) {
        $_ENV[$key] = $value;
    }
}

class Database
{
    private string $host;

    private string $port;

    private string $db;

    private string $user;

    private string $password;

    private string $charset;

    public function __construct()
    {
        $this->host = $_ENV["MYSQLHOST"] ?? getenv('MYSQLHOST');
        $this->port = $_ENV["MYSQLPORT"] ?? getenv('MYSQLPORT');
        $this->db = $_ENV["MYSQL_DATABASE"] ?? getenv('MYSQL_DATABASE');
        $this->user = $_ENV["MYSQLUSER"] ?? getenv('MYSQLUSER');
        $this->password = $_ENV["MYSQL_ROOT_PASSWORD"] ?? getenv('MYSQL_ROOT_PASSWORD');
        $this->charset = $_ENV["MYSQL_DATABASE_CHARSET"] ?? getenv('MYSQL_DATABASE_CHARSET');
    }

    public function connect()
    {
        try {
            $connection = "mysql:host={$this->host};port={$this->port};dbname={$this->db};charset={$this->charset}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            return new PDO($connection, $this->user, $this->password, $options);
        } catch (Exception $ex) {
            throw new Exception("Error en la conexión a la base de datos. $ex");
        }
    }
}