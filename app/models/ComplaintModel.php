<?php
class ComplaintModel extends Model
{
    public function addComplaint($complaint)
    {
        $insert_complaint = $this->insert('complaint', [
            'complainer_name' => $complaint['name'],
            'email' => $complaint['email'],
            'contact_no' => $complaint['contact_no'],
            'address' => $complaint['address'],
            'complaint_category' => $complaint['category'],
            'description' => $complaint['description'],
            'complaint_time' => $complaint['date'],
            'complaint_state' => 1,
        ]);

        if ($insert_complaint['success'] ?? false) {
            // Handle images
            $id = $this->conn->query('SELECT LAST_INSERT_ID() AS id');
            $id = $id ? ($id->fetch_all(MYSQLI_ASSOC)[0]['id'] ?? false) : false;
            if ($id !== false) {
                //Store Images
                $images = Upload::storeUploadedImages('confidential/Complaint', 'photos', true);
                $image_errors = [];
                if ($images !== false)
                    for ($i = 0; $i < count($images); ++$i) {
                        if (!empty($images[$i]['orig'])) {
                            $image_errors[] = [
                                $images[$i]['error'],
                                $images[$i]['orig']
                            ];
                            if ($images[$i]['error'] === false) {
                                $this->insert('complaint_images', [
                                    'complaint_id' => $id,
                                    'image_file_name' => $images[$i]['name']
                                ]);
                            }
                        }
                    }
                $insert_complaint['id'] = $id;
                $insert_complaint['image_errors'] = $image_errors;
                if (count(array_filter($image_errors, function ($i) {
                    return $i[0] !== false;
                })) > 0) {
                    $insert_complaint['success'] = false;
                    $this->delete('complaint', conditions: "complaint_id='$id'");
                } else {
                    header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $id);
                    die();
                }
            }
        }
        return $insert_complaint;
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
        $condtions = ['complaint_state =1'];
        if (isset($_GET['category']) && $_GET['category'] != 0) {
            $category = mysqli_real_escape_string($this->conn, $_GET['category']);
            $condtions[] = "b.complaint_category='$category'";
        }
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name, 
            b.complaint_time as complaint_time,b.complaint_state as complaint_state,
            c.category_name as category_name',
            $condtions
        );
    }

    public function get_complaint($id)
    {
        return [$this->select(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join complaint_status d on d.status_id = b.complaint_state',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.email as email, b.contact_no as contact_no,b.handle_by as handle_by,
            b.complaint_time as complaint_time,b.complaint_state as complaint_state, b.address as address, b.description as description,
            c.category_name as category_name,d.complaint_status as complaint_status',
            "complaint_id=$id"
        )['result'] ?? [], $this->select('complaint_images ci join file_original_names orn on orn.name=ci.image_file_name', 'orn.name as name,orn.orig as orig', "complaint_id=$id")['result'] ?? []];
    }

    public function get_notes($id)
    {
        // return $this->select("complaint_notes where complaint_id=$id");
        return $this->selectPaginated(
            'complaint_notes b join users c on b.handler_id=c.user_id',
            'b.complaint_id as complaint_id,b.note as note,
            b.note_time as note_time, 
            c.name as user_name',
            "complaint_id=$id"
        );
    }

    // public function get_all_accepted_complaints()
    // {
    //     return $this->selectPaginated(
    //         'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
    //         'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
    //         b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
    //         c.category_name as category_name, d.name as handler_name',
    //         "complaint_state =2 || complaint_state =3"
    //     );
    // }

    public function get_accepted_resolved_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.category_name as category_name, d.name as handler_name',
            "complaint_state =3"
        );
    }

    public function get_accepted_working_complaints()
    {
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.category_name as category_name, d.name as handler_name',
            "complaint_state =2"
        );
    }

    public function get_resolved_complaints()
    {
        $user_id = $_SESSION['user_id'];
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            "complaint_state =3 && handle_by= $user_id"
        );
    }

    public function get_working_complaints()
    {
        $user_id = $_SESSION['user_id'];
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            "complaint_state =2 && handle_by= $user_id"
        );
    }

    public function acceptComplaint($id)
    {
        $user_id = $_SESSION['user_id'];
        $stmt = "UPDATE complaint SET complaint_state=2, handle_by= $user_id, accept_time=CURRENT_TIMESTAMP() WHERE complaint_id=$id";
        $stmt = $this->conn->prepare($stmt);
        $stmt->bind_param('ii', $user_id, $id);
        $res = $stmt->execute();
        $accept = [
            'success' => $res == true && $stmt->affected_rows != 0,
            'error' => $res == false,
            'rows' => $res ? $stmt->affected_rows : false,
            'errmsg' => $res == false ? $stmt->error : false,
        ];
        if ($accept['success']) {
            header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $id);
        }
    }

    // public function add_notes($note)
    // {
    //     $note['handler_id'] = $_SESSION['user_id'];
    //     return $this->insert('complaint_notes', $note);
    // }
}
