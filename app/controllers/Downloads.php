<?php Class Downloads extends Controller {
    public function file($name)
    {
        $filepath = "downloads/$name";
        if (!file_exists($filepath)) {
            $filepath = 'public/assets/logo.jpg';
        }
        $model = new file_names;
        $original_name = $model->getOriginalName($name);
        if($original_name == false) {
            $original_name = basename($filepath);
        }
        header("Content-Description: File Transfer");
        $mime = mime_content_type($filepath);
        if ($mime) {
            header("Content-Type: $mime");
        }
        header("Content-Disposition: attachment; filename=\"" . $original_name . "\"");
        header("Content-Length: " . filesize($filepath));
        readfile($filepath);
        exit();
    }
    public function index(){
        $model = $this->model('DownloadsModel');
        $data = [];
        // Handle Adding Categories
        if(isset($_POST['AddCategory']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'category|l[1:255]|u[download_categories]'
            ],'AddCategory');
            if(count($err) == 0) {
                $data['AddCategory'] = $model->addCategory($valid);
            } else {
                $data['AddCatErrors'] = $err;
            }
        }

        // Handle Adding Files to Categories
        if(isset($_POST['AddFiles']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs($_POST,[
                'cat_id|i[:]'
            ],'AddFiles');
            if(count($err) == 0) {
                $data['AddFiles'] = $model->addFiles($valid['cat_id']);
            } else {
                $data['AddFilesErr'] = $err;
            }

        }

        // Handle Deleting Files
        if(isset($_POST['DeleteFile']) && ($_SESSION['role'] ?? 'Guest' == 'Admin')) {
            [$valid,$err] = $this->validateInputs( $_POST,[
                'cat_id|i[:]',
                'file_name'
            ],'DeleteFile');
            if(count($err) == 0) {
                $cat_id = $valid['cat_id'];
                $file_name = $valid['file_name'];
                $data['DeleteFile'] = $model->deleteFile($cat_id,$file_name);
            } else {
                $data['DeleteFileErr'] = $err;
            }
        }

        // Retrieve Data after handling any requests
        $data['categories'] = $model->getCategories();
        $data['cat_files'] = $model->getFilesByCategory();
        $this->view('Home/downloads','Downloads',$data,styles:['Home/downloads','Components/form','Components/table']);
    }
}