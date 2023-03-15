<?php
class file_names extends Model{
    public function putName($new_file_name,$original_name) {
        return $this->insert('file_original_names',[
            'name' => $new_file_name,
            'orig' => $original_name
        ]);
    }
    public function getOriginalName($generated_file_name) {
        $generated_file_name = mysqli_real_escape_string($this->conn,$generated_file_name);
        return $this->select('file_original_names',
            'orig',"name='$generated_file_name'"
        )['result'][0]['orig'] ?? false;
    }
    public function delName($generated_file_name) {
        $generated_file_name = mysqli_real_escape_string($this->conn,$generated_file_name);
        return $this->delete('file_original_names',
               "name='$generated_file_name'")['success'] ?? false;
    }
}

class Upload
{
    public static function storeUploadedImages($destination, $input_name = 'img')
    {
        // It is always assumed that the images are being uploaded as "multiple"
        if (isset($_FILES[$input_name])) {
            $images = $_FILES[$input_name];
            $img_count = count($images["name"]);
            $to_return = [];
            $model = new file_names;
            for ($i = 0; $i < $img_count; ++$i) {
                if ($images['error'][$i] == 0) {
                    $check = getimagesize($images['tmp_name'][$i]);
                    if ($check) {
                        if ($images['size'][$i] > 5000000) {
                            // Needs to be checked client side as well : DONE in upload_previews.js
                            // Load it after all forms with file uploads
                            array_push($to_return, [
                                'error' => true,
                                'errmsg' => 'too large',
                                'orig' => $images['name'][$i],
                            ]);
                        } else {
                            $img_id = uniqid('img_');
                            $img_ext = strtolower(pathinfo($images['name'][$i], PATHINFO_EXTENSION));
                            $target_file = rtrim($destination, '/\\') . "/$img_id.$img_ext";
                            $new_file_name = "$img_id.$img_ext";
                            if (move_uploaded_file($images['tmp_name'][$i], $target_file)) {
                                array_push($to_return, [
                                    'error' => false,
                                    'errmsg' => '',
                                    'name' => $new_file_name,
                                    'path' => $target_file,
                                    'orig' => $images['name'][$i],
                                ]);
                                $model->putName($new_file_name,$images['name'][$i]);
                            } else {
                                array_push($to_return, [
                                    'error' => true,
                                    'errmsg' => 'move error',
                                    'orig' => $images['name'][$i],
                                ]);
                            }
                        }
                    } else {
                        array_push($to_return, [
                            'error' => true,
                            'errmsg' => 'image check',
                            'orig' => $images['name'][$i],
                        ]);
                    }
                } else {
                    array_push($to_return, [
                        'error' => true,
                        'errmsg' => 'upload error ' . $images['error'][$i],
                        'orig' => $images['name'][$i],
                    ]);
                }
            }
            return $to_return;
        } else {
            return false;
        }
    }
    public static function storeUploadedFiles($destination, $input_name = 'fileupload', $omit_ext = false)
    {
        // It is always assumed that the files are being uploaded as "multiple"
        if (isset($_FILES[$input_name])) {
            $files = $_FILES[$input_name];
            $file_count = count($files["name"]);
            $to_return = [];
            $model = new file_names;
            for ($i = 0; $i < $file_count; ++$i) {
                if ($files['error'][$i] == 0) {
                    if ($files['size'][$i] > 5000000) {
                        // Needs to be checked client side as well : DONE in upload_previews.js
                        // Load it after all forms with file uploads
                        array_push($to_return, [
                            'error' => true,
                            'errmsg' => 'too large',
                            'orig' => $files['name'][$i],
                        ]);
                    } else {
                        $original_name = $files['name'][$i];
                        $file_id = uniqid("file_");
                        $file_ext = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
                        $new_file_name = "$file_id.$file_ext";
                        if ($omit_ext) {
                            $new_file_name = "$file_id";
                        }
                        $target_file = rtrim($destination, '/\\') . "/$new_file_name";
                        if (move_uploaded_file($files['tmp_name'][$i], $target_file)) {
                            array_push($to_return, [
                                'error' => false,
                                'errmsg' => '',
                                'path' => $target_file,
                                'name' => $new_file_name,
                                'orig' => $files['name'][$i],
                            ]);
                            $model->putName($new_file_name,$files['name'][$i]);
                        } else {
                            array_push($to_return, [
                                'error' => true,
                                'errmsg' => 'move error',
                                'orig' => $files['name'][$i],
                            ]);
                        }
                    }
                } else {
                    array_push($to_return, [
                        'error' => true,
                        'errmsg' => 'upload error',
                        'orig' => $files['name'][$i],
                    ]);
                }
            }
            return $to_return;
        } else {
            return false;
        }
    }
}
