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
        $this->view('Home/downloads',styles:['Home/downloads']);
    }
}