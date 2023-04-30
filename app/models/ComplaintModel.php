<?php
class ComplaintModel extends Model
{
    public function addComplaint($complaint)
    {
        return $this->insert('complaint', [
            'complainer_name' => $complaint['name'],
            'email' => $complaint['email'],
            'contact_no' => $complaint['contact_no'],
            'address' => $complaint['address'],
            'complaint_category' => $complaint['category'],
            'description' => $complaint['description'],
            'complaint_time' => $complaint['date'],
            'complaint_state' => 1,
        ]);
    }

    public function get_categories()
    {
        return $this->select('complaint_categories');
    }

    public function get_complaints()
    {
        return $this->select('complaint');
    }

    public function get_new_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name, 
            b.complaint_time as complaint_time,b.complaint_state as complaint_state,
            c.category_name as category_name',
            'complaint_state =1'
        );
    }

    public function get_complaint($id)
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join complaint_status d on d.status_id = b.complaint_state',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.email as email, b.contact_no as contact_no,b.handle_by as handle_by,
            b.complaint_time as complaint_time,b.complaint_state as complaint_state, b.address as address,b.description as description,
            c.category_name as category_name,d.complaint_status as complaint_status',
            "complaint_id=$id"
        );
    }

    public function get_all_accepted_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.category_name as category_name, d.name as handler_name',
            "complaint_state =2 || complaint_state =3"
        );
    }

    public function get_resolved_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            "complaint_state =3 && handle_by= 4"
        );
    }

    public function get_working_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            "complaint_state =2 && handle_by= 4"
        );
    }
}
