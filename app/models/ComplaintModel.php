<?php
class ComplaintModel extends Model
{
    // public function AddComplaint($name, $email, $mobi_num, $address, $category, $message, $date)
    // {
    //     return $this->insert('complaints', ['nameInputField' => $name, 'emailInputField' => $email, 'phoneInputField' => $mobi_num, 'addressInputField' => $address, 'selectOptionField' => $category, 'messageInputField' => $message, 'dateInputField' => $date]);
    // }
    
    public function AddComplaint($data)
    {
        return $this->insert('complaints',$data);
    }

    public function GetComplaint()
    {
        return $this->select('complaints');
    }
    public function GetComplaintById($id)
    {
        return $this->select('complaints', '*', "complaint_id=$id");
    }
}
