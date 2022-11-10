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

    protected function insert($table, $data)
    {
        // Expecting an associative array for the data with its keys being table columns
        // Concatenate column names with commas
        $cols = join(',', array_keys($data));
        $vals = [];

        // Check data types and add '' quotes to strings
        foreach ($data as $key => $value) {
            if (gettype($value) == 'string') {
                array_push($vals, "'$value'");
            } else {
                array_push($vals, $value);
            }
        }
        
        // Concatenate values with commas
        $vals = join(',', $vals);
        // Make sql statement 
        $sql = "INSERT INTO $table ($cols) VALUES ($vals)";
        // Execute the statement and return 
        return $this->conn->query($sql) === true;
    }

    public function __destruct()
    {
        // Closing the database connection
        $this->conn->close();
    }
}
