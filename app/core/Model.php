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
                // To escape special characters
                $value = mysqli_real_escape_string($this->conn, $value);
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
        // Start building the sql statement
        $sql = "UPDATE $table SET ";

        // Loop through array to get column,value pairs
        foreach ($data as $column => $value) {
            // Check type of value
            if (gettype($value) == 'string') {
                // To escape special characters
                $value = mysqli_real_escape_string($this->conn, $value);
                $sql .= "$column = '" . $value . "',";
            } else {
                $sql .= "$column = $value,";
            }
        }

        // Remove last comma from sql statement
        $sql = rtrim($sql, ",");
        // Add conditions to sql statement
        $sql .= " WHERE $conditions";
        // Execute sql statement and return result
        return $this->conn->query($sql);
    }

    protected function delete($table, $conditions)
    {
        // Sql statement for deleting
        $sql = "DELETE FROM $table WHERE $conditions";
        // Execute sql statement and return result
        return $this->conn->query($sql);
    }

    // SQL prepared statements
    protected function insertprep($table, $data)
    {
        // Concatenate column name with commas
        $keys = array_keys($data);
        $cols = join(',', $keys);
        $vals = [];
        // Data type variable used to track placeholder data type
        $dataType = "";

        // Check data types and add '' quotes to strings
        foreach ($data as $key => $value) {
            if (gettype($value) == 'string') {
                // To escape special characters
                $data[$key] = mysqli_real_escape_string($this->conn, $data[$key]);
                $vals[] = &$data[$key];
                $dataType .= "s";
            } else if (gettype($value) == 'double') {
                $vals[] = &$data[$key];
                $dataType .= "d";
            } else {
                $vals[] = &$data[$key];
                $dataType .= "i";
            }
        }

        try {
            // Prepare statement
            $stmt = $this->conn->prepare("INSERT INTO $table ($cols) VALUES (" . str_repeat('?,', count($keys) - 1) . "?)");
            // Bind data into prepared statement
            call_user_func_array(array($stmt, 'bind_param'), array_merge(array($dataType), $vals));

            // Execute the statement
            $res = $stmt->execute();
            return [
                'success' => $res == true,
                'error' => $res == false,
                'errmsg' => $res == false ? $stmt->error : false,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => true,
                'errmsg' => $e->getMessage(),
            ];
        }
    }

    protected function selectprep($table, $columns = '*', $conditions = '')
    {
        try {
            // Prepare statement
            if ($conditions != '') {
                $stmt = $this->conn->prepare("SELECT $columns FROM $table WHERE $conditions");
            } else {
                $stmt = $this->conn->prepare("SELECT $columns FROM $table");
            }

            // Execute the statement
            $res = $stmt->execute();
            $result = $res ? $stmt->get_result() : false;
            $nodata = $result->num_rows == 0;
            $result = $result ? $result->fetch_all(MYSQLI_ASSOC) : false;
            return [
                'error' => $res == false,
                'errmsg' => $res == false ? $stmt->error : false,
                'nodata' => $nodata,
                'result' => $result,
            ];
        } catch (Exception $e) {
            return [
                'error' => true,
                'errmsg' => $e->getMessage(),
                'nodata' => true,
                'result' => false,
            ];
        }
    }

    protected function updateprep($table, $data, $conditions)
    {
        $column = [];
        $vals = [];
        // Data type variable used to track placeholder data type
        $dataType = "";

        // Check the data type
        foreach ($data as $key => $value) {
            // Add placeholders to each column
            $column[] = "$key=?";

            if (gettype($value) == 'string') {
                // To escape special characters
                $data[$key] = mysqli_real_escape_string($this->conn, $data[$key]);
                $vals[] = &$data[$key];
                $dataType .= "s";
            } else if (gettype($value) == 'double') {
                $vals[] = &$data[$key];
                $dataType .= "d";
            } else {
                $vals[] = &$data[$key];
                $dataType .= "i";
            }
        }

        try {
            // Prepare statement
            $stmt = $this->conn->prepare("UPDATE $table SET " . join(',', $column) . " WHERE $conditions");
            // Bind data into prepared statement
            call_user_func_array(array($stmt, 'bind_param'), array_merge(array($dataType), $vals));
            // Execute the statement
            $res = $stmt->execute();
            return [
                'success' => $res == true && $stmt->affected_rows != 0,
                'error' => $res == false,
                'rows' => $res ? $stmt->affected_rows : false,
                'errmsg' => $res == false ? $stmt->error : false,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => true,
                'rows' => false,
                'errmsg' => $e->getMessage(),
            ];
        }
    }

    protected function deleteprep($table, $conditions)
    {
        try {
            // Prepare statement
            $stmt = $this->conn->prepare("DELETE FROM $table WHERE $conditions");
            // Execute the statement
            $res = $stmt->execute();
            return [
                'success' => $res == true && $stmt->affected_rows != 0,
                'error' => $res == false,
                'rows' => $res ? $stmt->affected_rows : false,
                'errmsg' => $res == false ? $stmt->error : false,
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'error' => true,
                'rows' => false,
                'errmsg' => $e->getMessage(),
            ];
        }
    }

    public function __destruct()
    {
        // Closing the database connection
        $this->conn->close();
    }
}
