<?php

namespace App\Config;

use Exception;
use mysqli;

//Display MYSQLI ERROR
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

class Database
{

    private $connection;

    public function __construct()
    {
        $this->host = $_ENV['DB_HOST'];
        $this->port = $_ENV['DB_PORT'];
        $this->database   = $_ENV['DB_DATABASE'];
        $this->username = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
    }

    public function db()
    {
        try {
            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database, $this->port);
        } catch (Exception $e) {
            die("Database connection failed! Message: " . $e->getMessage());
            exit;
        }

        return $this->connection;
    }

    public function close(): void
    {
        $this->db()->close();
    }
}
