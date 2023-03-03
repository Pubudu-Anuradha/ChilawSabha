<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select(
            'user', 'name,password_hash,type', "email='$email'"
        );
    }
    public function getStaffRole($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select(
            'user u join staff s on u.user_id=s.user_id and u.type="Staff"', 's.Role as role', "u.email='$email'"
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
}
