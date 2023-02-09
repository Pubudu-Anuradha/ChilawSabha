<?php
class Files extends Controller{
    public function download($name)
    {
        $filepath = "downloads/$name";
        if (file_exists($filepath)) {
            header("Content-Description: File Transfer");
            $mime = mime_content_type($filepath);
            if ($mime) {
                header("Content-Type: $mime");
            }
            header("Content-Disposition: attachment; filename=\"" . basename($filepath) . "\"");
            header("Content-Length: " . filesize($filepath));
        }
        readfile($filepath);
        exit();
    }

    public function confidential($role,$name,$download = false)
    {
        // Example : URLROOT . '/Files/confidential/Admin/file.pdf/true'
        $this->authenticateRole($role,'/public/assets/forbidden.png');
        $filepath = "confidential/$role/$name";
        if (file_exists($filepath)) {
            $mime = mime_content_type($filepath);
            if ($mime) {
                header("Content-Type: $mime");
            }
            if($download){
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=\"" . basename($filepath) . "\"");
                header("Content-Length: " . filesize($filepath));
            }
        }
        readfile($filepath);
        exit();
    }
}