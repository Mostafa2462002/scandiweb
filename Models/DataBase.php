<?php

namespace App\Models;

use Dotenv\Dotenv;

class DataBase
{
    private $DB_SERVER;
    private $DB_USERNAME;
    private $DB_PASSWORD;
    private $DB_NAME;
    private $conn; // Connection object

    private static  $instance = null;

    // Private constructor to prevent instantiation
    private function __construct()
    {
        $this->loadEnv();
        $this->getConnection();
    }

    // Load environment variables
    private function loadEnv()
    {
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();

        $this->DB_SERVER = $_ENV['DB_SERVER'];
        $this->DB_USERNAME = $_ENV['DB_USERNAME'];
        $this->DB_PASSWORD = $_ENV['DB_PASSWORD'];
        $this->DB_NAME = $_ENV['DB_NAME'];
    }

    // Get the single instance of the class
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Get the database connection
    public function getConnection()
    {
        if ($this->conn === null) {
            try {
                $this->conn = new \mysqli($this->DB_SERVER, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_NAME);
                if ($this->conn->connect_error) {
                    throw new \Exception("Connection failed: " . $this->conn->connect_error);
                }
            } catch (\Exception $e) {
                echo "Connection error: " . $e->getMessage();
                exit();
            }
        }
        return $this->conn;
    }
}
