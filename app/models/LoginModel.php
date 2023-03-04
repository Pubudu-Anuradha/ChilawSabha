<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('users', conditions: "email='$email'");
    }
    public function getStaffRole($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('users u join staff s on u.user_id=s.user_id and u.user_type=1', 's.staff_type as type_id', "u.email='$email'");
    }
}
