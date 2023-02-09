<?php
class LoginModel extends Model
{
    public function getUserCredentials($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('user', 'name,password_hash,type', "email='$email'");
    }
    public function getStaffRole($email)
    {
        $email = mysqli_real_escape_string($this->conn,$email);
        return $this->select('user u join staff s on u.email=s.email and u.type="Staff"', 's.Role as role', "u.email='$email'");
    }
}
