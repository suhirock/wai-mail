<?php
/**
 * contact
 * 
 * var .1.3
 * 
 * @todo meta_set to method in Util
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
    if(basename(@$_SERVER['HTTP_REFERER']) === 'confirm' && $_util->is_complete($Config['slugs'])){
        $param['title'] = $Config['titles']['complete'];
        $param['description'] = $Config['descs']['complete'];
        $param['keyword'] = $Config['keywords']['complete'];
        $page = __DIR__.'/tpl/contact-complete.php';
    } else {
        // フォーム以外のダイレクトなアクセスをフォームへリダイレクト
        $_util->check_redirect_direct_confirm($Config['basename']);
        
        $param['csrf'] = $_util->csrf();
        $param['title'] = $Config['titles']['form'];
        $param['description'] = $Config['descs']['form'];
        $param['keyword'] = $Config['keywords']['form'];
        $page = __DIR__.'/tpl/contact-form.php';
    }
}

// バリデーション
if(empty($page) && $_SERVER['REQUEST_METHOD'] === 'POST'){

    if($_util->csrf()){

        require_once __DIR__.'/class/WaiValidation.php';
        $_vali = new waiValidation();

        if(!isset($_POST['send'])){

            //確認
            if(!empty($Config['validation'])){
                foreach($Config['validation'] as $r){
                    $_vali->rule($r[0],$r[1],$r[2]);
                }
            }

            $param['csrf'] = $_POST[$_util->csrfkey];
            $param['post'] = $_POST;
            

            if($_vali->isError()){
                $param['errors'] = $_vali->errors();
                $param['title'] = $Config['titles']['form'];
                $param['description'] = $Config['descs']['form'];
                $param['keyword'] = $Config['keywords']['form'];
                $page = __DIR__.'/tpl/contact-form.php';
            } else {
                if(!empty($_POST['back'])){
                    $param['title'] = $Config['titles']['form'];
                    $param['description'] = $Config['descs']['form'];
                    $param['keyword'] = $Config['keywords']['form'];
                    $page = __DIR__.'/tpl/contact-form.php';
                } else {
                    $param['hidden'] = $_POST;
                    $param['title'] = $Config['titles']['confirm'];
                    $param['description'] = $Config['descs']['confirm'];
                    $param['keyword'] = $Config['keywords']['confirm'];
                    $page = __DIR__.'/tpl/contact-confirm.php';
                }
            }

        } else {

            //送信
            require_once __DIR__.'/class/WaiSend.php';
            $_send = new WaiSend();
            $param['post'] = $_POST;
            $body = $_send->mail_render($Config['admin_mail_template'],$param);

            if($_send->go(
                    $Config['admin_mail']['to'],
                    $Config['admin_mail']['subject'],
                    $body,
                    $Config['admin_mail']['from'],
                    $Config['admin_mail']['from_name'],
                    $Config['admin_mail']['cc'],
                    $Config['admin_mail']['bcc']
                )
            ){
                $_re_send = new WaiSend();

                // 送信先の設定
                if(empty($Config['reply_mail']['to'])){
                    $Config['reply_mail']['to'] = '{email}';
                }
                if(preg_match('/^{.+}$/',$Config['reply_mail']['to'],$matches)){
                    $reply_to_key = preg_replace('/{|}/','',$Config['reply_mail']['to']);
                    $re_to = !empty($param['post'][$reply_to_key]) ? $param['post'][$reply_to_key] : '';
                } else {
                    $re_to = !empty($Config['reply_mail']['to']) ? $Config['reply_mail']['to'] : '';
                }

                if(!empty($re_to)){
                    $re_subject = !empty($Config['reply_mail']['subject']) ? $Config['reply_mail']['subject'] : 'お問い合わせありがとうございます。';
                    $re_from = !empty($Config['reply_mail']['from']) ? $Config['reply_mail']['from'] : $Config['admin_mail']['from'];
                    $re_fromName = !empty($Config['reply_mail']['from_name']) ? $Config['reply_mail']['from_name'] : $Config['admin_mail']['from_name'];
                    $re_body = $_send->mail_render($Config['reply_mail_template'],$param);

                    // 自動返信メール
                    $_re_send->go(
                        $re_to,
                        $re_subject,
                        $re_body,
                        $re_from,
                        $re_fromName
                    );
                }
                
                // データの削除
                $param = array();
                session_destroy();
                header('Location:./'.$Config['slugs']['complete']);
                exit;
            }

        }
    
    } else {
        $param['title'] = $Config['titles']['error'];
        $param['description'] = $Config['descs']['error'];
        $param['keyword'] = $Config['keywords']['error'];
        $param['errors']['csrf'] = 'ページ移動で不正がありました。';
        $page = __DIR__.'/tpl/contact-error.php';
    }
}

$_util->render($page,$param);