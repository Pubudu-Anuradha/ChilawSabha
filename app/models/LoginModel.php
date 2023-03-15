<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('users', conditions: "email='$email'");
    }
    public function getStaffRoleId($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('users u join staff s on u.user_id=s.user_id and u.user_type=1', 's.staff_type as type_id', "u.email='$email'");
    }

    public function getPasswordResetCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select(
            'users', 'email,password_reset_code,reset_code_time', "email='$email'"
        );
    }

    public function setResetCode($email, $data){
        $email = mysqli_real_escape_string($this->conn,$email);
        $resetTime = $this->update('users', [
            'password_reset_code' => $data['resetCode'],
            'reset_code_time' => $data['resetTime'],
        ], "email='$email'");
        return [
            'resetTime' => $resetTime,
        ];
    }

    public function changePassword($email, $password){
        $email = mysqli_real_escape_string($this->conn,$email);
        $password = mysqli_real_escape_string($this->conn,$password);
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $resetPassword = $this->update('users', [
            'password_hash' => $password_hash,
            'password_reset_code' => null,
            'reset_code_time' => null,
        ], "email='$email'");
        return [
            'resetPassword' => $resetPassword,
        ];
    }

    public function removeResetDetails($email){
        $email = mysqli_real_escape_string($this->conn,$email);
        $resetPassword = $this->update('users', [
            'password_reset_code' => null,
            'reset_code_time' => null,
        ], "email='$email'");
        return [
            'removeReset' => $removeReset,
        ];
    }
}
