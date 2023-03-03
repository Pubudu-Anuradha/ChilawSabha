<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select(
            'users', 'name,password_hash,user_type', "email='$email'"
        );
    }
    public function getStaffRole($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select(
            'users u join staff s on u.user_id=s.user_id and u.user_type=1 join staff_type t on s.staff_type=t.staff_type_id', 't.staff_type as role', "u.email='$email'"
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
