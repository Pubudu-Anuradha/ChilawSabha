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
            array_push($styles, 'loggedin_layout');
        }
        require_once 'app/views/Header.php';
        if ($this->logged_in_user) {
            require_once 'app/views/' . $_SESSION['role'] . '/Sidebar.php';
        }
        require_once 'app/views/' . $view . '.php';
        require_once 'app/views/Footer.php';
    }

    //Check authenitation for a role by seeing if session variables are set properly.
    //If not, redirect to appropriate page using $redir parameter
    public function authenticateRole($role, $redir = '/Home/')
    {
        if (!isset($_SESSION['login'])) {
            header('location:' . URLROOT . $redir);
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
        if (isset($data[$submitMethod])) {
            unset($data[$submitMethod]);
        }
        $validated = [];
        $errors = [];

        $set_error = function ($name, $value) use (&$errors) {
            if (!isset($errors[$name])) {
                $errors[$name] = [$value];
            } else {
                $errors[$name][] = $value;
            }
        };

        foreach ($fields as $field) {
            $options = explode('|', $field);
            $field = $options[0];
            unset($options[0]);

            // ? can be used to say a field is allowed to be empty
            $can_be_empty = array_search('?', $options);
            if ($can_be_empty === false) {
                if (!isset($data[$field])) {
                    $set_error('missing', $field);
                    continue;
                } else if (empty($data[$field])) {
                    $set_error('empty', $field);
                    continue;
                }
            }
            unset($options[$can_be_empty]);
            if(!empty($data[$field])){
                // Not empty, Checking rules.
                // Rules follow the precedence order as set in this function.
                // No need to worry about rule order when calling the function.

                $number_range_rule = preg_grep('/^[i|d]\[\d*:\d*\]$/', $options);
                if(count($number_range_rule) > 1){
                    throw new Exception("Too Many number rules. Use Only one", 1);
                }else if(count($number_range_rule) == 1){
                    try {
                        $rule = $number_range_rule[0];
                        $val = $rule[0] == 'i' ? intval($data[$field]) : doubleval($data[$field]);
                        [$min, $max] = explode(':', ltrim(rtrim($rule, ']'), 'id['));
                        if (!empty($min)) {
                            $min = $rule[0] == 'i' ? intval($min) : doubleval($min);
                            if ($val < $min) {
                                $set_error('min', $field);
                                continue;
                            }
                        }
                        if (!empty($max)) {
                            $max = $rule[0] == 'i' ? intval($max) : doubleval($max);
                            if ($val > $max) {
                                $set_error('max', $field);
                                continue;
                            }
                        }
                        $validated[$field] = $val;
                        continue;
                    } catch (Exception $e) {
                        $set_error('number', $field);
                        continue;
                    }
                }

                $string_length_rule = preg_grep('/^l\[\d*:\d*\]$/', $options);
                if(count($string_length_rule) > 1){
                    throw new Exception("Too Many String length rules. Use only one", 1);
                }else if(count($string_length_rule)==1){
                    try {
                        $rule = $string_length_rule[0];
                        $val = strlen($data[$field]);
                        [$min, $max] = explode(':', ltrim(rtrim($rule, ']'), 'l['));
                        // echo "$val :: [$min:$max]\n";
                        if (!empty($min)) {
                            $min = intval($min);
                            if ($val < $min) {
                                $set_error('min_len', $field);
                                continue;
                            }
                        }
                        if (!empty($max)) {
                            $max = intval($max);
                            if ($val > $max) {
                                $set_error('max_len', $field);
                                continue;
                            }
                        }
                        // echo "$val :: [$min:$max]\n";
                    } catch (Exception $e) {
                        // Should probably ignore
                        $set_error('strlen', $field);
                    }

                }

                $email_rule = array_search('e',$options);
                if($email_rule !== false){
                    if(!filter_var($data[$field],FILTER_VALIDATE_EMAIL)){
                        $set_error('email',$field);
                    }else{
                        $validated[$field] = $data[$field];   
                    }
                    continue;
                }

            }

            // $validated[$field] = $data[$field];
            // if (isset($data[$field])) {
            //     // Add fields with non empty value to validated array
            //     $validated[$field] = $data[$field] . "$field";
            //     unset($data[$field]); // remove the field from original array
            // } else {
            //     // false if either field isn't set or value is empty
            //     return false;
            // }
        }

        // if ($data) {
        //     // False if more data is left on $data
        //     return false;
        // }

        // return the valid data
        // return $validated;
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
