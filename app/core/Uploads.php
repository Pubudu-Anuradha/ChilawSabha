<?php
class Upload
{
    public static function storeUploadedImages($destination, $input_name = 'img')
    {
        // It is always assumed that the images are being uploaded as "multiple"
        if (isset($_FILES[$input_name])) {
            $images = $_FILES[$input_name];
            $img_count = count($images["name"]);
            $to_return = [];
            for ($i = 0; $i < $img_count; ++$i) {
                if($images['error'][$i]==0){
                    $check = getimagesize($images['tmp_name'][$i]);
                    if($check){
                        if($images['size'][$i] > 5000000){ // Needs to be checked cleint side as well
                            array_push($to_return,[
                                'error' =>true,
                                'errmsg'=>'too large',
                                'orig' =>$images['name'][$i]
                            ]);
                        }else{
                            $img_id = uniqid('img_');
                            $img_ext = strtolower(pathinfo($images['name'][$i],PATHINFO_EXTENSION));
                            $target_file = rtrim($destination,'/\\')."/$img_id.$img_ext";
                           if(move_uploaded_file($images['tmp_name'][$i],$target_file)){
                                array_push($to_return,[
                                    'error' =>false,
                                    'errmsg' =>'',
                                    'path' => $target_file,
                                    'orig' =>$images['name'][$i]
                                ]);
                           }else{
                                array_push($to_return,[
                                    'error' =>true,
                                    'errmsg' =>'move error',
                                    'orig' =>$images['name'][$i]
                                ]);
                           }
                        }

                    }else{
                        array_push($to_return,[
                            'error' =>true,
                            'errmsg' =>'failed image check',
                            'orig' =>$images['name'][$i]
                        ]);
                    }
                }else{
                    array_push($to_return,[
                        'error' =>true,
                        'errmsg' =>'upload error ' . $images['error'][$i],
                        'orig' =>$images['name'][$i]
                    ]);
                }
            }
            return $to_return;
        } else {
            return false;
        }
    }
    public static function storeUploadedFiles($destination, $input_name = 'fileupload')
    {
        // It is always assumed that the files are being uploaded as "multiple"
        if (isset($_FILES[$input_name])) {
            $files = $_FILES[$input_name];
            $file_count = count($files["name"]);
            $to_return = [];
            for ($i = 0; $i < $file_count; ++$i) {
                if($files['error'][$i]==0){
                    if($files['size'][$i] > 5000000){ // Needs to be checked cleint side as well
                        array_push($to_return,[
                            'error' =>true,
                            'errmsg'=>'too large',
                            'orig' =>$files['name'][$i]
                        ]);
                    }else{
                        $original_name = $files['name'][$i];
                        $file_id = uniqid("file_$original_name");
                        $file_ext = strtolower(pathinfo($original_name,PATHINFO_EXTENSION));
                        $target_file = rtrim($destination,'/\\')."/$file_id.$file_ext";
                        if(move_uploaded_file($files['tmp_name'][$i],$target_file)){
                            array_push($to_return,[
                                'error' =>false,
                                'errmsg' =>'',
                                'path' => $target_file,
                                'orig' =>$files['name'][$i]
                            ]);
                        }else{
                            array_push($to_return,[
                                'error' =>true,
                                'errmsg' =>'move error',
                                'orig' =>$files['name'][$i]
                            ]);
                        }
                    }
                }else{
                    array_push($to_return,[
                        'error' =>true,
                        'errmsg' =>'upload error',
                        'orig' =>$files['name'][$i]
                    ]);
                }
            } 
            return $to_return;
        } else {
            return false;
        }
    }
}

