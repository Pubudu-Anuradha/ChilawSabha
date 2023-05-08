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
        $condtions = ["complaint_id=$id"];
        $condtions = implode(' && ', $condtions);
        return [$this->select(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join complaint_status d on d.status_id = b.complaint_state',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.email as email, b.contact_no as contact_no,b.handle_by as handle_by,
            b.complaint_time as complaint_time,b.complaint_state as complaint_state, b.address as address, b.description as description,
            c.category_name as category_name,d.complaint_status as complaint_status',
            $condtions
        )['result'] ?? [], $this->select('complaint_images ci join file_original_names orn on orn.name=ci.image_file_name', 'orn.name as name,orn.orig as orig', "complaint_id=$id")['result'] ?? []];
    }

    public function get_notes($id)
    {
        $condtions = ["complaint_id=$id"];
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint_notes b join users c on b.handler_id=c.user_id',
            'b.complaint_id as complaint_id,b.note as note,
            b.note_time as note_time, 
            c.name as user_name',
            $condtions
        );
    }

    public function get_accepted_resolved_complaints()
    {
        $condtions = ['complaint_state =3'];
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.category_name as category_name, d.name as handler_name',
            $condtions
        );
    }

    public function get_accepted_working_complaints()
    {
        $condtions = ['complaint_state =2'];
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.category_name as category_name, d.name as handler_name',
            $condtions
        );
    }

    public function get_resolved_complaints()
    {
        $user_id = $_SESSION['user_id'];
        $condtions = ["complaint_state =3 && handle_by= $user_id"];
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            $condtions
        );
    }

    public function get_working_complaints()
    {
        $user_id = $_SESSION['user_id'];
        $condtions = ["complaint_state =2 && handle_by= $user_id"];
        $condtions = implode(' && ', $condtions);
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.category_name as category_name',
            $condtions
        );
    }

    public function acceptComplaint($id)
    {
        $user_id = $_SESSION['user_id'];
        $stmt = "UPDATE complaint SET complaint_state=2, handle_by= ?, accept_time=CURRENT_TIMESTAMP() WHERE complaint_id=?";
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
        } else {
            return $accept;
        }
    }

    public function finishComplaint($id)
    {
        $user_id = $_SESSION['user_id'];
        $stmt = "UPDATE complaint SET complaint_state=3, handle_by= ?, accept_time=CURRENT_TIMESTAMP() WHERE complaint_id=?";
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
        } else {
            return $accept;
        }
    }
    // public function get_complaint_counts()
    // {
    //     $result = $this->select(
    //         'complaint b join complaint_status c on b.complaint_state=c.status_id',
    //         'c.complaint_status as state, COUNT(*) as count',
    //         null,
    //         'c.complaint_status='
    //     );

    //     $counts = array();
    //     foreach ($result['result'] ?? [] as $row) {
    //         $counts[] = array(
    //             'state' => $row['state'],
    //             'count' => $row['count']
    //         );
    //     }

    //     return $counts;
    // }

    // public function get_complaint_counts()
    // {
    //     $result = $this->select(
    //         'COUNT(complaint_state) AS working_count FROM Complaint where complaint_state=2'
    //     );

    //     return $result;
    // }

    public function addNotes($note)
    {
        $insert_note = $this->insert('complaint_notes', [
            'handler_id' => $note['user_id'],
            'note' => $note['note'],
            'complaint_id' => $note['complaint_id'],
        ]);
        return $insert_note;
    }
    
}
