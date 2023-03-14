<?php
class ComplaintModel extends Model
{
    public function addComplaint($data)
    {
        return $this->callProcedure('putcomplaint',[
            $data['name'],
            $data['email'],
            $data['phone_number'],
            $data['address'],
            $data['category'],
            $data['message'],
        ]);
    }

    // public function getComplaint()
    // {
    //     return $this->select(
    //         'post p join announcement a on p.id=a.id',
    //         'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as description,p.date as date,a.category as category,a.author as author',
    //         "p.id"
    //     );
    // }

    // public function getComplaintById($id)
    // {
    //     return $this->select(
    //         'post p join announcement a on p.id=a.id',
    //         'p.id as id,p.title as title,a.shortdesc as shortdesc,p.content as description,p.date as date,a.category as category,a.author as author',
    //         "p.id=$id"
    //     );
    // }
}
