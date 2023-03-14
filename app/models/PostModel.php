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

    
}