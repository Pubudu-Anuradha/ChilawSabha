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
                return ['put_announcement' => $id,$image_errors,$attach_errors];
            }
        }
        return false;
    }

    protected function editPost($edited_post_data) {
        // keep a copy of old post record

        //try to update

        // if update goes well put edit history
        // don't care about success of edit history.
    }

    // Put the data present in the fields prior to editing as a record in post_edit table
    private function putEditHistory($edit_post_details) {

    }
}