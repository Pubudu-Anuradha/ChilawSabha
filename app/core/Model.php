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

    public function insert($table, $data)
    {
        // Concatenate column name with commas
        $keys = array_keys($data);
        $cols = join(',', $keys);
        $vals = [];
        // Data type variable used to track placeholder data type
        $dataType = "";
        $binds = [];

        // Check data types and add '' quotes to strings
        foreach ($data as $key => $value) {
            if (is_null($value)) {
                array_push($binds, 'NULL');
            } else if (gettype($value) == 'string') {
                $vals[] = &$data[$key];
                $dataType .= "s";
                array_push($binds, '?');
            } else if (gettype($value) == 'double') {
                $vals[] = &$data[$key];
                $dataType .= "d";
                array_push($binds, '?');
            } else {
                $vals[] = &$data[$key];
                $dataType .= "i";
                array_push($binds, '?');
            }
        }

        try {
            // Prepare statement
            $stmt = $this->conn->prepare("INSERT INTO $table ($cols) VALUES (" . implode(',', $binds) . ")");
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

    public function select($table, $columns = '*', $conditions = '', $offsetlimt = false)
    {
        try {
            if ($offsetlimt) {
                /* $offsetlimit [0] = OFFSET
                $offsetlimit [1] = ROW_COUNT per page */
                $limit = $offsetlimt[0] . ',' . $offsetlimt[1];
                // Prepare statement
                if ($conditions != '') {
                    $stmt = $this->conn->prepare("SELECT $columns FROM $table WHERE $conditions LIMIT $limit");
                } else {
                    $stmt = $this->conn->prepare("SELECT $columns FROM $table LIMIT $limit");
                }
            } else {
                // Prepare statement
                if ($conditions != '') {
                    $stmt = $this->conn->prepare("SELECT $columns FROM $table WHERE $conditions");
                } else {
                    $stmt = $this->conn->prepare("SELECT $columns FROM $table");
                }
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

    public function selectPaginated($table, $columns = '*', $conditions = '', $page_name = 'page', $page_size_name = 'size')
    {
        $row_count = $this->select($table, 'COUNT(*) as recordCount', $conditions);
        $row_count = !$row_count['error'] && !$row_count['nodata'] ? (int) $row_count['result'][0]['recordCount'] : 0;

        // $page is set from page number and size set on $_GET
        $page = [0, 10];
        if (isset($_GET[$page_name]) && $_GET[$page_name] > 0) {
            $page[0] = (int) $_GET[$page_name];
        }
        if (isset($_GET[$page_size_name]) && $_GET[$page_size_name] > 10) {
            $page[1] = (int) $_GET[$page_size_name];
        }
        // Convert page number to offset
        $page[0] *= $page[1];

        // reset offset to zero if limit is exceeded
        if ($page[0] > $row_count) {
            $page[0] = 0;
        }

        return array_merge(
            $this->select($table, $columns, $conditions, $page), [
                'count' => $row_count,
                'page' => $page,
            ]
        );
    }

    public function update($table, $data, $conditions)
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

    public function delete($table, $conditions)
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

    public function callProcedure($procedure, $fields)
    {
        // $fields is a numeric array.[Order Matters]
        // Use this method only if necessary.
        $prep_fields = [];
        // Data type variable used to track placeholder data type
        $dataType = "";
        $prep_fields = [];
        $binds = [];

        // Check the data type
        for ($i = 0; $i < count($fields); ++$i) {
            if (is_null($fields[$i])) {
                array_push($binds, 'NULL');
            } else if (gettype($fields[$i]) == 'string') {
                $prep_fields[] = &$fields[$i];
                $dataType .= "s";
                array_push($binds, '?');
            } else if (gettype($fields[$i]) == 'double') {
                $prep_fields[] = &$fields[$i];
                $dataType .= "d";
                array_push($binds, '?');
            } else {
                $prep_fields[] = &$fields[$i];
                $dataType .= "i";
                array_push($binds, '?');
            }
        }
        try {
            // Prepare statement
            $sql = "CALL $procedure(" . implode(',', $binds) . ")";
            $stmt = $this->conn->prepare($sql);
            // Bind data into prepared statement
            call_user_func_array(array($stmt, 'bind_param'), array_merge(array($dataType), $prep_fields));

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

    public function exists($table, $conditions, $condition_separator = ' && ')
    {
        // Function to check whether any record exists in $table
        // that satisfies the given conditions
        // * will fail silently if there are errors

        $conditions_formatted = [];
        $binds = [""];
        foreach ($conditions as $col => $val) {
            $string = "$col = ";
            if (is_null($val)) {
                $string .= 'NULL';
            } else if (is_string($val)) {
                $binds[] = &$conditions[$col];
                $binds[0] .= "s";
                $string .= '?';
            } else if (is_double($val)) {
                $binds[] = &$conditions[$col];
                $binds[0] .= "d";
                $string .= '?';
            } else {
                $binds[] = &$conditions[$col];
                $binds[0] .= "i";
                $string .= '?';
            }
            $conditions_formatted[] = $string;            
        }
        $conditions = implode($condition_separator,$conditions_formatted);

        $stmt =$this->conn->prepare("SELECT COUNT(*) AS count FROM $table WHERE $conditions");
        call_user_func_array(array($stmt, 'bind_param'), $binds);
        $res = $stmt->execute();
        $result = $res ? $stmt->get_result() : false;
        $result = $result ? $result->fetch_all(MYSQLI_ASSOC) : false;

        return ($result !== false) && (($result[0]['count'] ?? 0 ) !== 0);
    }

    public function __destruct()
    {
        // Closing the database connection
        $this->conn->close();
    }
}
