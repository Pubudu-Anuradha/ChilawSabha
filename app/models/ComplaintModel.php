<?php
class ComplaintModel extends Model
{
    public function AddComplaint($name, $email, $mobi_num, $address, $category, $message, $date)
    {
        return $this->insert('newComplaints', ['name' => $name, 'email' => $email, 'mobi_num' => $mobi_num, 'address' => $address, 'category' => $category, 'message' => $message, 'date' => $date]);
    }
    public function GetComplaint()
    {
        return $this->select('newComplaints');
    }
}
