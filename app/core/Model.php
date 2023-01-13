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
        try {
            return $this->conn->query($sql) === true;
        } catch (Exception) {
            return false;
        }
    }

    protected function select($table, $columns = '*', $conditions = '')
    {
        // Make sql statement with table name , columns
        $sql = "SELECT $columns FROM $table";
        // If there are conditions add to the sql with WHERE
        if ($conditions != '') {
            $sql = "$sql WHERE $conditions";
        }
        // Statement executes and the result is returned
        return $this->conn->query($sql);
    }

    protected function update($table, $data, $conditions)
    {
        // TODO Implement update function
    }

    protected function delete($table, $data, $conditions)
    {
        // TODO Implement delete function
    }

    public function __destruct()
    {
        // Closing the database connection
        $this->conn->close();
    }
}
