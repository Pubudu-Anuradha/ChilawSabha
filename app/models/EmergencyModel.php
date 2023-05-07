<?php
class EmergencyModel extends Model
{
    public function addCategory($data) {
        return $this->insert('emergency_categories',$data);
    }

    public function getCategories() {
        return $this->select('emergency_categories');
    }

    public function addPlaceToCategory($data) {
        return $this->insert('emergency_places',$data);
    }

    public function editPlace($place_id,$data) {
        foreach($data as $field => $value){
            if(is_null($value)) unset($data[$field]);
        }
        return $this->update('emergency_places',$data,"place_id = $place_id");
    }

    public function deletePlace($place_id) {
        $place_id = mysqli_real_escape_string($this->conn,$place_id);
        return $this->delete('emergency_places',"place_id = '$place_id'");
    }

    public function getPlace($place_id) {
        $place_id = mysqli_real_escape_string($this->conn,$place_id);
        return $this->select('emergency_places',"place_id = '$place_id'");
    }

    public function getPlaces() {
        return $this->select('emergency_places');
    }
}