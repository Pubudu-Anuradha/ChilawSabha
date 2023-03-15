<?php
class Access extends Controller {
    public function confidential($role,$name,$download = false)
    {
        // Example : URLROOT . '/Access/confidential/Admin/file.pdf/true'
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