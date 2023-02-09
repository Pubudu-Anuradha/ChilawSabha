<?php
class EmergencyModel extends Model
{

    public function getAllEmergencyDetails()
    {
        return $this->select('emergency_details INNER JOIN em_places ON emergency_details.category_id = em_places.category_id INNER JOIN em_tel ON em_places.place_id = em_tel.place_id',
        'emergency_details.category_name as category_name, em_places.place_name as place_name, em_places.place_address as place_address, em_tel.tel as tel');
    }    

    public function getSpecificEmergencyCategoryDetails($category_id)
    {
        return $this->select('em_places', '*', "category_id='$category_id'");
    }

    /* Need to implement multi_query insert */

    public function addNewEmergencyPlace($data)
    {
        return $this->multi_insert(['em_places', 'em_tel'], $data);
    }
}