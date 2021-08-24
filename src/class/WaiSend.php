<?php
/**
 * wai send
 * 
 * ver .1.2
 */

require_once __DIR__.'/../lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__.'/../lib/PHPMailer/src/SMTP.php';
require_once __DIR__.'/../lib/PHPMailer/src/POP3.php';
require_once __DIR__.'/../lib/PHPMailer/src/Exception.php';
require_once __DIR__.'/../lib/PHPMailer/src/OAuth.php';
require_once __DIR__.'/../lib/PHPMailer/language/phpmailer.lang-ja.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class WaiSend {

    private $charset = "UTF-8";
    private $origin_set = "AUTO";

    /**
     * mail用のrender
     */
    public function mail_render(string $file, array $param) {
        $_util = $this;
        ob_start();
        require_once $file;
        $content = ob_get_contents();
        ob_end_clean();
        foreach($param['post'] as $k => $v){
            $content = str_replace('{'.$k.'}',$v,$content);
        }
        $content = preg_replace('/{[a-zA-Z_-]+?}/','',$content);
        return $content;
	}

    /**
     * go
     * 送信
     */
    public function go(
        $to=null,
        $subject=null,
        $body=null,
        $from=null,
        $fromName=null,
        $cc=array(),
        $bcc=array()
    ){
        mb_language("japanese");
        mb_internal_encoding($this->charset);

        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        // $mail->isSMTP();                                            //Send using SMTP
        // $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        // $mail->Username   = 'user@example.com';                     //SMTP username
        // $mail->Password   = 'secret';                               //SMTP password
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        // $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        $mailer = new PHPMailer();
        $mailer->CharSet = $this->charset;
        $message = $body;
        $mailer->From = $from;
        $mailer->FromName = mb_convert_encoding($fromName,$this->charset,$this->origin_set);
        $mailer->Subject  = mb_convert_encoding($subject,$this->charset,$this->origin_set);
        $mailer->Body = mb_convert_encoding($body,$this->charset,$this->origin_set);
        $mailer->addAddress($to);
        if(is_array($cc) && count($cc) > 0){
            foreach($cc as $v){
                $mailer->addCC($v);
            }
        }
        if(is_array($bcc) && count($bcc) > 0){
            foreach($bcc as $v){
                $mailer->addBCC($v);
            }
        }
        
        if(! $mailer->Send()){
            echo '送信失敗しました。';
            return false;
        }

        return true;
    }

}