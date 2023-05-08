<?php
class ComplaintModel extends Model
{
    public function addComplaint($complaint)
    {
        // Insert complaint details into the 'complaint' table
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
            // Handle image
            // Get the ID of the newly inserted complaint
            $id = $this->conn->query('SELECT LAST_INSERT_ID() AS id');
            $id = $id ? ($id->fetch_all(MYSQLI_ASSOC)[0]['id'] ?? false) : false;
            
            // If ID was successfully retrieved
            if ($id !== false) {
                //Store Images
                $images = Upload::storeUploadedImages('confidential/Complaint', 'photos', true); // Store the uploaded images in a directory
                $image_errors = [];// Create an empty array to store any image upload errors
                if ($images !== false) 
                    for ($i = 0; $i < count($images); ++$i) { // Iterate through the uploaded images

                        // If the image was successfully uploaded
                        if (!empty($images[$i]['orig'])) {
                            $image_errors[] = [
                                $images[$i]['error'],
                                $images[$i]['orig']
                            ];

                            // If there were no errors in saving the image file to directory
                            if ($images[$i]['error'] === false) {

                                // Insert image details into the 'complaint_images' table
                                $this->insert('complaint_images', [
                                    'complaint_id' => $id,
                                    'image_file_name' => $images[$i]['name']
                                ]);
                            }
                        }
                    }
                $insert_complaint['id'] = $id; // Set the ID of the newly inserted complaint in the response array
                $insert_complaint['image_errors'] = $image_errors; // Set any image upload errors in the response array
                if (count(array_filter($image_errors, function ($i) {
                    return $i[0] !== false;
                })) > 0) {
                    $insert_complaint['success'] = false; // Set 'success' flag to false in the response array
                    $this->delete('complaint', conditions: "complaint_id='$id'"); // Delete the newly inserted complaint from the 'complaint' table
                } else {
                    header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $id); // Redirect to the complaint view page with the ID of the newly inserted complaint

                    die();
                }
            }
        }
        return $insert_complaint;
    }

    public function addComplaintuser($complaint)
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
                    header('Location: ' . URLROOT . '/Home/index');
                    die();
                }
            }
        }
        return $insert_complaint;
    }

    public function get_categories()
    {
        //retrieve all rows from the 'complaint_categories' table.
        return $this->select('complaint_categories'); // 
    }

    public function get_new_complaints()
    {
        $condtions = ['complaint_state =1']; // Set the initial conditions for the query, which is that the complaint_state is 1 (new complaint)
        if (isset($_GET['category']) && $_GET['category'] != 0) { // Check if a category filter has been applied
            // If a category filter has been applied, add it as a condition to the query
            $category = mysqli_real_escape_string($this->conn, $_GET['category']);
            $condtions[] = "b.complaint_category='$category'";
        }

        // Convert the conditions array to a string that can be used in the SQL query using the implode function
        $condtions = implode(' && ', $condtions);

        // Use the selectPaginated() method of the base model class to retrieve paginated rows from the 'complaint' table joined with the 'complaint_categories' table.
        return $this->selectPaginated(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name, 
            b.complaint_time as complaint_time,b.complaint_state as complaint_state,
            c.complaint_category as category_name',
            $condtions
        );
    }

    public function get_complaint($id)
    {
        $condtions = ["complaint_id=$id"]; // Build the conditions for the SQL query.
        $condtions = implode(' && ', $condtions);
        
        // Retrieve the complaint details and its images using SQL JOINs.
        return [$this->select(
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join complaint_status d on d.status_id = b.complaint_state',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.email as email, b.contact_no as contact_no,b.handle_by as handle_by,
            b.complaint_time as complaint_time,b.complaint_state as complaint_state, b.address as address, b.description as description,
            c.complaint_category as category_name,d.complaint_status as complaint_status',
            $condtions
        )['result'] ?? [], 
        // Retrieve the complaint's images.
        $this->select('complaint_images ci join file_original_names orn on orn.name=ci.image_file_name', 'orn.name as name,orn.orig as orig', "ci.complaint_id=$id")['result'] ?? []];
    }

    public function get_notes($id)
    {
        $condtions = ["complaint_id=$id"]; // Build the conditions for the SQL query.
        $condtions = implode(' && ', $condtions);  // Convert the conditions array to a string that can be used in the SQL query using the implode function
        return $this->selectPaginated(    // retrieve paginated rows from the 'complaint_notes' table joined with the 'users' table.
            'complaint_notes b join users c on b.handler_id=c.user_id',
            'b.complaint_id as complaint_id,b.note as note,
            b.note_time as note_time, 
            c.name as user_name',
            $condtions
        );
    }

    public function get_accepted_resolved_complaints()
    {
        $condtions = ['complaint_state =3'];  // Set the initial conditions for the query, which is that the complaint_state is 3 (resolved complaint)
        $condtions = implode(' && ', $condtions);  // Convert the conditions array to a string that can be used in the SQL query using the implode function
        return $this->selectPaginated( // retrieve paginated rows from the 'complaint' table joined with the 'complaint_categories' table and 'users' table.
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.complaint_category as category_name, d.name as handler_name',
            $condtions
        );
    }

    public function get_accepted_working_complaints()
    {
        $condtions = ['complaint_state =2'];  // Build the conditions for the SQL query.
        $condtions = implode(' && ', $condtions);  // Convert the conditions array to a string that can be used in the SQL query using the implode function
        return $this->selectPaginated( // retrieve paginated rows from the 'complaint' table joined with the 'complaint_categories' table and 'users' table.
            'complaint b join complaint_categories c on b.complaint_category=c.category_id join users d on d.user_id=b.handle_by',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,b.handle_by as handle_by,
            b.complaint_time as complaint_time, b.complaint_state as complaint_state, 
            c.complaint_category as category_name, d.name as handler_name',
            $condtions
        );
    }

    public function get_resolved_complaints()
    {
        $user_id = $_SESSION['user_id'];
        $condtions = ["complaint_state =3 && handle_by= $user_id"];
        $condtions = implode(' && ', $condtions);  // Convert the conditions array to a string that can be used in the SQL query using the implode function
        return $this->selectPaginated(  // retrieve paginated rows from the 'complaint' table joined with the 'complaint_categories' table.
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.complaint_category as category_name',
            $condtions
        );
    }

    public function get_working_complaints()
    {
        $user_id = $_SESSION['user_id'];
        $condtions = ["complaint_state =2 && handle_by= $user_id"];
        $condtions = implode(' && ', $condtions);   // Convert the conditions array to a string that can be used in the SQL query using the implode function
        return $this->selectPaginated(  // retrieve paginated rows from the 'complaint' table joined with the 'complaint_categories' table.
            'complaint b join complaint_categories c on b.complaint_category=c.category_id',
            'b.complaint_id as complaint_id,b.complainer_name as complainer_name,
            b.complaint_time as complaint_time, 
            c.complaint_category as category_name',
            $condtions
        );
    }

    public function acceptComplaint($id)
    {
        $user_id = $_SESSION['user_id']; // Get the ID of the user accepting the complaint from the session.
        // Prepare the SQL statement to update the complaint with the assigned handler and accept time.
        $stmt = "UPDATE complaint SET complaint_state=2, handle_by= ?, accept_time=CURRENT_TIMESTAMP() WHERE complaint_id=?";
        $stmt = $this->conn->prepare($stmt);
        $stmt->bind_param('ii', $user_id, $id); // Bind the parameters to the prepared statement.
        $res = $stmt->execute(); // Execute the prepared statement.
        $accept = [ // Create an array containing the success status, error status, number of affected rows and error message (if any).
            'success' => $res == true && $stmt->affected_rows != 0,
            'error' => $res == false,
            'rows' => $res ? $stmt->affected_rows : false,
            'errmsg' => $res == false ? $stmt->error : false,
        ];
        if ($accept['success']) {
            header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $id); // If the complaint was successfully accepted, redirect to the complaint view page.
        } else {
            return $accept;
        }
    }

    public function finishComplaint($id)
    {
        $user_id = $_SESSION['user_id']; // Get the ID of the user accepting the complaint from the session.
         // Prepare the SQL statement to update the complaint with the assigned handler and resolve time.
        $stmt = "UPDATE complaint SET complaint_state=3, handle_by= ?, resolve_time=CURRENT_TIMESTAMP() WHERE complaint_id=?";
        $stmt = $this->conn->prepare($stmt);
        $stmt->bind_param('ii', $user_id, $id); // Bind the parameters to the prepared statement.
        $res = $stmt->execute();  // Execute the prepared statement.
        $accept = [  // Create an array containing the success status, error status, number of affected rows and error message (if any).
            'success' => $res == true && $stmt->affected_rows != 0,
            'error' => $res == false,
            'rows' => $res ? $stmt->affected_rows : false,
            'errmsg' => $res == false ? $stmt->error : false,
        ];
        if ($accept['success']) {
            header('Location: ' . URLROOT . '/Complaint/viewComplaint/' . $id); // If the complaint was successfully accepted, redirect to the complaint view page.
        } else {
            return $accept;
        }
    }

    public function addNotes($note)
    {   //insert to complaint_notes table
        $insert_note = $this->insert('complaint_notes', [
            'handler_id' => $note['user_id'],
            'note' => $note['note'],
            'complaint_id' => $note['complaint_id'],
        ]);
        return $insert_note;
    }

    public function get_complaint_counts()
    {
         $result = $this->select('complaint',
                'COUNT(complaint_id) AS working_count',
                'complaint_state=2'
            );
        return $result;
    }
    
}
