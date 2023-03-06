<?php

class Controller
{
    //Flag used to render the relevant sidebar when a user logged in
    protected $logged_in_user = false;

    //A function for child classes to get an instance of a defined model
    public function model($model)
    {
        require_once 'app/models/' . $model . '.php';
        return new $model();
    }

    //Render a defined view and pass the data provided by the caller
    public function view($view, $title = 'Chilaw Pradeshiya Sabha', $data = [], $styles = [])
    {
        if ($this->logged_in_user) {
            array_push($styles, 'logged_in_layout');
        }
        require_once 'app/views/Header.php';
        if ($this->logged_in_user) {
            require_once 'app/views/' . $_SESSION['role'] . '/Sidebar.php';
        }
        require_once 'app/views/' . $view . '.php';
        require_once 'app/views/Footer.php';
    }

    //Check authentication for a role by seeing if session variables are set properly.
    //If not, redirect to appropriate page using $redirect parameter
    public function authenticateRole($role, $redirect = '/Home/')
    {
        if (!isset($_SESSION['login'])) {
            header('location:' . URLROOT . $redirect);
            die();
        } else if ($_SESSION['role'] != $role) {
            header('location:' . URLROOT . '/Other/Forbidden');
            die();
        } else {
            $this->logged_in_user = true;
        }
    }

    protected function validateInputs($data, $fields, $submitMethod = 'Submit')
    {
        // Rules can be set in fields separated by '|' to do some basic validation here itself.
        // Available rules are
        // '?'          <- Optional(can be empty or not given) -> missing|empty
        // 'i[min:max]' <- Integer in inclusive range(values are both optional) -> min|max|number
        // 'd[min:max]' <- Same as above but using double -> min|max|number
        // 'l[min:max]' <- String length in inclusive range -> min_len|max_len
        // 'e'          <- Validate Email -> email
        // 'u[table]'    <- Check uniqueness -> unique|unique_check

        if (isset($data[$submitMethod])) {
            unset($data[$submitMethod]);
        }
        $old = json_encode($data);
        $validated = [];
        $errors = [];

        $set_error = function ($name, $field) use (&$errors, &$data) {
            if (!isset($errors[$name])) {
                $errors[$name] = [$field];
            } else {
                $errors[$name][] = $field;
            }
            if(is_array($field)){
                if(isset($data[$field[0] ?? false])){
                    unset($data[$field[0]]);
                }
            } else if (isset($data[$field])) {
                unset($data[$field]);
            }
        };

        $set_validated = function ($field) use (&$validated, &$data,&$old) {
            if (isset($data[$field])) {
                $validated[$field] = $data[$field];
                unset($data[$field]);
            } else {
                throw new Exception(json_encode([$old,$field , $data]) . " Trying to set a non existing value as validated", 1);
            }
        };

        foreach ($fields as $field) {
            $rules = explode('|', $field);
            $field = $rules[0];
            unset($rules[0]);

            $can_be_empty = array_search('?', $rules);
            if ($can_be_empty === false) {
                if (!isset($data[$field])) {
                    $set_error('missing', $field);
                    continue;
                } else if (empty($data[$field])) {
                    $set_error('empty', $field);
                    continue;
                }
            }
            unset($rules[$can_be_empty]);
            if (!empty($data[$field])) {
                // Not empty, Checking rules.
                // Rules follow the precedence order as set in this function.
                // No need to worry about rule order when calling the function.

                $unique_rule = preg_grep('/^u\[.*\]$/', $rules) ?? false;
                if($unique_rule !== false && count($unique_rule) > 1){
                    throw new Exception("Too Many unique rules. Use Only one", 1);
                } else if ($unique_rule !== false && count($unique_rule) == 1) {
                    try {
                        $done = false;
                        foreach($unique_rule as $rule) {
                            $table = rtrim(ltrim(ltrim($rule,'u'),'['),']');
                            if(empty($table)) throw new Exception(
                                    "Make sure unique rule has non_empty table name"
                                );
                            else {
                                $model = new Model;
                                if($model->exists($table,[$field => $data[$field]])) {
                                    $set_error('unique',$field);
                                    $done = true;
                                    continue;
                                }
                            }
                        }
                        if($done) continue;
                    } catch(Exception $e) {
                        $set_error('unique_check',$field);
                    }
                }

                $number_range_rule = preg_grep('/^[i|d]\[\d*:\d*\]$/', $rules) ?? false;
                if ($number_range_rule !== false && count($number_range_rule) > 1) {
                    throw new Exception("Too Many number rules. Use Only one", 1);
                } else if ($number_range_rule !== false && count($number_range_rule) == 1) {
                    try {
                        $done = false;
                        foreach($number_range_rule as $_ => $rule){
                            $val = $rule[0] ?? 'i' == 'i' ? intval($data[$field]) : doubleval($data[$field]);
                            $split = explode(':', ltrim(rtrim($rule, ']'), 'id['));
                            $min = $split[0] ?? '';
                            $max = $split[1] ?? '';
                            if (!empty($min)) {
                                $min = $rule[0] == 'i' ? intval($min) : doubleval($min);
                                if ($val < $min) {
                                    $set_error('min', [$field,$min]);
                                    $done = true;
                                    continue;
                                }
                            }
                            if (!empty($max)) {
                                $max = $rule[0] == 'i' ? intval($max) : doubleval($max);
                                if ($val > $max) {
                                    $set_error('max', [$field,$max]);
                                    $done = true;
                                    continue;
                                }
                            }
                            $set_validated($field);
                            $done = true;
                        }
                        if($done) continue;
                    } catch (Exception $e) {
                        $set_error('number', $field);
                        continue;
                    }
                }

                $string_length_rule = preg_grep('/^l\[\d*:\d*\]$/', $rules);
                if ($string_length_rule!==false && count($string_length_rule) > 1) {
                    throw new Exception("Too Many String length rules. Use only one", 1);
                } else if (count($string_length_rule) == 1) {
                    try {
                        $done = false;
                        foreach($string_length_rule as $_ => $rule){
                            $rule = $string_length_rule[1] ?? false;
                            $val = strlen($data[$field]);
                            $split = explode(':', ltrim(rtrim($rule, ']'), 'l['));
                            $min = $split[0] ?? '';
                            $max = $split[1] ?? '';
                            if (!empty($min)) {
                                $min = intval($min);
                                if ($val < $min) {
                                    $set_error('min_len', [$field,$min]);
                                    $done = true;
                                    continue;
                                }
                            }
                            if (!empty($max)) {
                                $max = intval($max);
                                if ($val > $max) {
                                    $set_error('max_len', [$field,$max]);
                                    $done = true;
                                    continue;
                                }
                            }
                        }
                        if($done) continue;
                    } catch (Exception $e) {
                        // Should probably ignore
                        $set_error('strlen', $field);
                        continue;
                    }

                }

                $email_rule = array_search('e', $rules);
                if ($email_rule !== false) {
                    if (!filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
                        $set_error('email', $field);
                    } else {
                        $set_validated($field);
                    }
                    continue;
                }
                // TODO: Add more rules as required
                // ! MUST UPDATE GENERAL ERROR HANDLER COMPONENT WHEN ADDING NEW RULES

                // Rules ended. set field as valid
                $set_validated($field);
            } else {
                // Set null if '?' rule is present and no value given
                $validated[$field] = null;
                if (isset($data[$field])) {
                    unset($data[$field]);
                }
            }
        }

        if ($data) {
            // Rules not defined for these fields
            foreach ($data as $key => $value) {
                $set_error('extra?', [$key => $value]);
            }
        }

        return [
            $validated, $errors,
        ];
    }

    public function returnJSON(array $var)
    {
        header("Content-type: application/json");
        echo json_encode($var);
    }
}
