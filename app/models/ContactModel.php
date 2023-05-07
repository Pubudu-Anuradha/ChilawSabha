<?php
class ContactModel extends Model {
    public function putCard($data) {
        return $this->insert('contact_card',$data);
    }

    public function editCard($id,$data) {
        foreach($data as $field => $value){
            if(is_null($value)) unset($data[$field]);
        }
        return $this->update('contact_card',$data,"card_id = $id");
    }

    public function deleteCard($id) {
        $id = mysqli_real_escape_string($this->conn,$id);
        return $this->delete('contact_card',"card_id = '$id'");
    }

    public function getCard($id) {
        $id = mysqli_real_escape_string($this->conn,$id);
        return $this->select('contact_card',"card_id = '$id'");
    }

    public function getCards() {
        return $this->select('contact_card');
    }
}