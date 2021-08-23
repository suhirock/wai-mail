<?php
/**
 * contact
 * 
 * var .1.3
 */

// 直接アクセス禁止
$__if = get_included_files();
if (array_shift($__if) === __FILE__) {
    die;
}

// セッション開始
session_start();

require_once __DIR__.'/class/WaiContactUtil.php';
$_util = new WaiContactUtil();
$param = [];
$param['csrfkey'] = $_util->csrfkey;

// 初回
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $param['csrf'] = $_util->csrf();
    $param['title'] = 'お問い合わせフォーム';
    $page = __DIR__.'/tpl/contact-form.php';
}

// バリデーション
if(empty($page) && $_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_util->csrf()){

        require_once __DIR__.'/class/wai-validation.class.php';
        $_vali = new waiValidation();

        if(!isset($_POST['send'])){
            
            //確認
            if(!empty($_rules)){
                foreach($_rules as $r){
                    $_vali->rule($r[0],$r[1],$r[2]);
                }
            }

            $param['csrf'] = $_POST[$_util->csrfkey];
            $param['post'] = $_POST;
            
            if($_vali->isError()){
                $param['errors'] = $_vali->errors();
                $page = __DIR__.'/tpl/contact-form.php';
            } else {
                if(!empty($_POST['back'])){
                    $page = __DIR__.'/tpl/contact-form.php';
                } else {
                    $param['hidden'] = $_POST;
                    $page = __DIR__.'/tpl/contact-confirm.php';
                }
            }

        } else {
            //送信
            require_once __DIR__.'/class/wai-send.class.php';
            $_send = new waiSend();
            $param['post'] = $_POST;
            $body = $_send->mail_render(__DIR__.'/tpl/mail-to.php',$param);

            if($_send->go($to,$subject,$body,$from,$fromName)){
                $_re_send = new waiSend();
                $re_to = !empty($re_to_key) ? $param['post'][$re_to_key] : $param['post']['email'];
                $re_subject = !empty($re_subject) ? $re_subject : 'お問い合わせありがとうございます。';
                $re_from = !empty($re_from) ? $re_from : $from;
                $re_fromName = !empty($re_fromName) ? $re_fromName : $fromName;
                $re_body = $_send->mail_render(__DIR__.'/tpl/mail-replay.php',$param);
                
                $_re_send->go($re_to,$re_subject,$re_body,$re_from,$re_fromName);

                // データの削除
                $param = array();
                session_destroy();
                
                header('Location:./complete.php');
                exit;
            }

        }
    
    } else {
        $param['errors']['csrf'] = 'ページ移動で不正がありました。';
        $page = __DIR__.'/tpl/contact-error.php';
    }
}

$_util->render($page,$param);