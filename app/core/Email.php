<?php 
require_once 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/phpmailer/phpmailer/src/Exception.php';
require_once 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once 'vendor/phpmailer/phpmailer/src/SMTP.php';

trait Email{
    private static string $Host     = "smtp.gmail.com";
    private static string $Username = "chlawpsproject@gmail.com";
    private static string $Password = "ksbslwlvdbghcbmp";

    // Function to send an HTML email
    // $to = one email address as a string or an array of emails
    // $content can be formatted using html
    public static function send(string|array $to, $subject, $content){
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = Email::$Host;
        $mail->Username   = Email::$Username;
        $mail->Password   = Email::$Password;

        $mail->IsHTML(true);
        if (is_string($to)){
            try {
                $mail->AddAddress($to);
            }catch(Exception $e){
                return [
                    'error'=>true,
                    'errmsg'=>"Error adding target address: $to"
                ];
            }
        }else if(is_array($to)){
            foreach($to as $addr){
                try {
                    $mail->AddAddress($addr);
                }catch(Exception $e){
                    return [
                        'error'=>true,
                        'errmsg'=>"Error adding target address: $addr"
                    ];
                }
            }
        }
        $mail->SetFrom(Email::$Username);
        $mail->Subject = $subject;

        $mail->MsgHTML($content);
        if ($mail->Send()) {
            return [
                'error'=>false, 
                'errmsg'=>''
            ];
        } else {
           return [
                'error'=>true,
                'errmsg'=>"Error while sending Email"
           ];
        }
    }
}