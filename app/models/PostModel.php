<?php class PostModel extends Model {

    /*
    TODO: add pin and visibility bools to post table
    ! Derive template
    class XModel extends PostModel
     * getX long|short
     * putX  {Separate post and X -> call putPost with post data -> if successful put X data to table}
     * editX {Separate post and X edit data -> call editPost with post only data}
     * // Keep pins and de lists in edit itself
     * warn if too  many pinned
     ? Do tables with JSON?
    */
    protected function putPost($post_data,int $post_type) {
        // Put common post data in post_table
        unset($post_data['attachments']);
        unset($post_data['photos']);
        $post_data['post_type'] = $post_type;
        $post_data['posted_by'] = $_SESSION['user_id'];
        $post_data['views'] = 0;
        $insert = $this->insert('post',$post_data);
        if($insert['success'] ?? false) {
            // handle images and attachments
            $id = $this->conn->query('SELECT LAST_INSERT_ID() AS id');
            $id = $id ? ($id->fetch_all(MYSQLI_ASSOC)[0]['id'] ?? false) : false;
            if($id !== false) {
                //Store Images
                $images = Upload::storeUploadedImages('public/upload/','photos');
                $image_errors = [];
                if($images !== false)
                    for($i=0;$i < count($images); ++$i) {
                        $image_errors[] = [
                            $images[$i]['error'],
                            $images[$i]['orig']
                        ];
                        if($images[$i]['error'] === false) {
                            $this->insert('post_images',[
                                'post_id' => $id,
                                'image_file_name' => $images[$i]['name']
                            ]);
                        }
                    }
                // Store Attachments
                $attachments = Upload::storeUploadedFiles('downloads/','attachments',true);
                $attach_errors = [];
                if($attachments !== false)
                    for($i=0;$i < count($attachments); ++$i) {
                        $attach_errors[] = [
                            $attachments[$i]['error'],
                            $attachments[$i]['orig']
                        ];
                        if($attachments[$i]['error'] === false) {
                            $this->insert('post_attachments',[
                                'post_id' => $id,
                                'attach_file_name' => $attachments[$i]['name']
                            ]);
                        }
                    }
                return ['put' => [$id,$image_errors,$attach_errors]];
            }
        }
        return false;
    }

    public function getPostById($id) {
        $id = mysqli_real_escape_string($this->conn,$id);
        return $this->select('post',conditions:"post_id='$id'")['result'][0] ?? false;
    }

    public function editPost($id,$edited_post_data) {
        $id = mysqli_real_escape_string($this->conn,$id);
        $current = $this->select('post',conditions:"post_id='$id'")['result'][0] ?? false;
        if($current!== false) {
            if($this->update('post',$edited_post_data,"post_id='$id'")['success'] ?? false) {
                foreach($edited_post_data as $field => $_) {
                    $edited_post_data[$field] = $current[$field];
                }
                $edited_post_data['post_id'] = $current['post_id'];
                $edited_post_data['edited_by'] = $_SESSION['user_id'];
                return $this->insert('post_edit',$edited_post_data)['success'] ?? false;
            }
        }
        return false;
    }

    public function getPhotoCount($id) {
        $id = mysqli_real_escape_string($this->conn,$id);
        return $this->select('post_images','count(*) as count',
            "post_id='$id'")['result'][0]['count'];
    }

    // public function getAttachCount($id) {
    //     $id = mysqli_real_escape_string($this->conn,$id);
    //     return $this->select('post_attachments','count(*) as count',
    //         "post_id='$id'")['result'][0]['count'];
    // }

    public function addPhotos($id,$name = 'photos') {
        $id = mysqli_real_escape_string($this->conn,$id);
        if($this->exists('post',['post_id'  => $id])) {
            //store images
            $current_photo_count = $this->getPhotoCount($id);
            if(count($_FILES[$name] ?? []) + $current_photo_count > 10) {
                return ['error' => 'more_than_10'];
            }
            $images = Upload::storeUploadedImages('public/upload/','photos');
            $image_errors = [];
            if($images !== false)
                for($i=0;$i < count($images); ++$i) {
                    $image_errors[] = [
                        $images[$i]['error'],
                        $images[$i]['orig']
                    ];
                    if($images[$i]['error'] === false) {
                        $this->insert('post_images',[
                            'post_id' => $id,
                            'image_file_name' => $images[$i]['name']
                        ]);
                    }
                }
            return $image_errors;
        }
        return ['error' => 'no post'];
    }

    public function addAttachments($id,$name='attachments') {
        $id = mysqli_real_escape_string($this->conn,$id);
        if($this->exists('post',['post_id'  => $id])){
            // Store Attachments
            $attachments = Upload::storeUploadedFiles('downloads/',$name,true);
            $attach_errors = [];
            if($attachments !== false)
                for($i=0;$i < count($attachments); ++$i) {
                    $attach_errors[] = [
                        $attachments[$i]['error'],
                        $attachments[$i]['orig']
                    ];
                    if($attachments[$i]['error'] === false) {
                        $this->insert('post_attachments',[
                            'post_id' => $id,
                            'attach_file_name' => $attachments[$i]['name']
                        ]);
                    }
                }
            return $attach_errors;
        }
        return ['error'=>'no_post'];
    }

    public function removePhoto($id,$file_name) {
        $id = mysqli_real_escape_string($this->conn,$id);
        $file_name = mysqli_real_escape_string($this->conn,$file_name);
        $delete = $this->delete('post_images',
            "post_id='$id' && image_file_name='$file_name'")['success'] ?? false;
        if($delete && unlink('public/upload/' . $file_name)) {
            $this->delete('file_original_names',"name='$file_name'");
        }
        return $delete;
    }

    public function removeAttach($id,$file_name) {
        $id = mysqli_real_escape_string($this->conn,$id);
        $file_name = mysqli_real_escape_string($this->conn,$file_name);
        $delete = $this->delete('post_attachments',
            "post_id='$id' && attach_file_name='$file_name'")['success'] ?? false;
        if($delete && unlink('downloads/' . $file_name)){
            $this->delete('file_original_names',"name='$file_name'");
        }
        return $delete;
    }
}