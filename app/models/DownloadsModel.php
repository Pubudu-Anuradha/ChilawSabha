<?php
class DownloadsModel extends Model {
    public function addCategory($data) {
        return $this->insert('download_categories',$data)['success'] ?? false;
    }

    public function getCategories() {
        return $this->select('download_categories',conditions:
        '1 ORDER BY category ASC')['result'] ?? [];
    }

    public function addFiles($cat_id,$name='files') {
        $cat_id = mysqli_real_escape_string($this->conn,$cat_id);
        if($this->exists('download_categories',['cat_id'  => $cat_id])){
            // Store Files
            $files = Upload::storeUploadedFiles('downloads/',$name,true);
            $errors = [];
            if($files !== false)
                for($i=0;$i < count($files); ++$i) {
                    $errors[] = [
                        $files[$i]['error'],
                        $files[$i]['orig']
                    ];
                    if($files[$i]['error'] === false) {
                        $this->insert('download_files',[
                            'cat_id' => $cat_id,
                            'file_name' => $files[$i]['name']
                        ]);
                    }
                }
            return $errors;
        }
        return ['error'=>'no_category'];
    }

    public function deleteFile($cat_id,$file_name) {
        $cat_id = mysqli_real_escape_string($this->conn,$cat_id);
        $file_name = mysqli_real_escape_string($this->conn,$file_name);
        $delete = $this->delete('download_files',
            "cat_id='$cat_id' && file_name='$file_name'")['success'] ?? false;
        if($delete && unlink('downloads/' . $file_name)){
            $this->delete('file_original_names',"name='$file_name'");
        }
        return $delete;
    }

    public function getFilesByCategory($cat_id = 0, $all=true) {
        $cat_id = mysqli_real_escape_string($this->conn,$cat_id);
        return $this->select('download_files d join file_original_names fon
                              on d.file_name=fon.name',
                             'fon.name as name, fon.orig as orig, d.cat_id as cat_id,
                              d.added_time as added_time',
                             $all ? '' : "d.cat_id='$cat_id'")['result'] ?? [];
    }
}