<?php
class StaffUserModel extends Model
{
    public function AddUser($user)
    {
        $passhash = password_hash($user['password'], PASSWORD_DEFAULT);
        unset($user['password']);
        $user['password_hash'] = $passhash;
        return $this->insert('staff', $user);
    }

    public function GetUsers()
    {
        return $this->select('staff');
    }
}
