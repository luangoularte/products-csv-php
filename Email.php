<?php 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


//Load Composer's autoloader
require 'vendor/autoload.php';


class Email {

    public static function enviaEmail($arquivo) {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      
            $mail->isSMTP();                                          
            $mail->Host       = 'smtp.gmail.com';                     
            $mail->SMTPAuth   = true;                                  
            $mail->Username   = 'luan.ag2012gk@gmail.com';                    
            $mail->Password   = 'jgny mrcp citm gkkc';                               
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           
            $mail->Port       = 465;
            $mail->SMTPAuth = true;
        
            $mail->setFrom('luan.ag2012gk@gmail.com', 'Teste');
            $mail->addAddress('luan.ag2012gk@gmail.com', 'Luan');
        
            $mail->addAttachment($arquivo); //attachment para envio de arquivo
        
            $mail->isHTML(true);                                  
            $mail->Subject = 'Teste Desafio';
            $mail->Body    = '<h1>Arquivo</h1>';
            $mail->AltBody = 'Arquivo produtos';
        
            $mail->send();
        
            echo 'Email enviado com sucesso';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    
}