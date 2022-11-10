<?php
class Model
{
    protected $conn;

    public function __construct()
    {
        // Establishing database connection
        $this->conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($this->conn->connect_error) {
            die('database Connection Failed' . $this->conn->connect_error);
        }
    }

    public function __destruct()
    {
        // Closing the database connection
        $this->conn->close();
    }
}
