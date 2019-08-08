<?php
/**
 * wai send
 * 
 * ver .1
 */

require_once __DIR__.'/../lib/PHPMailer/src/PHPMailer.php';
require_once __DIR__.'/../lib/PHPMailer/src/SMTP.php';
require_once __DIR__.'/../lib/PHPMailer/src/POP3.php';
require_once __DIR__.'/../lib/PHPMailer/src/Exception.php';
require_once __DIR__.'/../lib/PHPMailer/src/OAuth.php';
require_once __DIR__.'/../lib/PHPMailer/language/phpmailer.lang-ja.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class waiSend {
    public function go(
            $to=null,
            $subject=null,
            $from=null,
            $header=array('cc' => array(), 'bcc' => array()
        )
    ){
        mb_language("japanese");
        mb_internal_encoding("UTF-8");

        $mailer = new PHPMailer();
        var_dump($mailer);
    }
}