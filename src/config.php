<?php
/**
 * Config
 * 
 * .1.3
 */
$Config = [
    /**
     * basename
     */
    'basename' => basename(__DIR__),

    /**
     * URL setting
     * 
     * confirm
     * complete
     */
    'slugs' => [
        'confirm' => 'confirm',
        'complete' => 'complete',
    ],
   
    /**
     * Header file path
     */
    'header' => __DIR__.'/tpl/common-header.php',

    /**
     * Footer file path
     */
    'footer' => __DIR__.'/tpl/common-footer.php',

    /**
     * Mail template to admin
     */
    'admin_mail_template' => __DIR__.'/tpl/mail-to.php',

    /**
     * Mail template to reply
     */
    'reply_mail_template' => __DIR__.'/tpl/mail-reply.php',

    /**
     * バリデーション
     * 
     * バリデーションタイプ
     * - exist : 必須項目
     * - email : email形式のチェック
     * - same => target :
     * 
     * 例（末尾はコンマで）
     * [ 'name', 'お名前', ['exist'] ],
     * [ 'email', 'メールアドレス', ['exist', 'email'] ],
     * [ 'email2', 'メールアドレス確認', ['exist', 'email', 'same'=>'email'] ],
     * [ 'privacy', '同意が必要です。', ['exist'] ],
     */
    'validation' => [
        [ 'name', 'お名前', ['exist'] ],
        [ 'email', 'メールアドレス', ['exist', 'email'] ],
        [ 'email2', 'メールアドレス確認', ['exist', 'email', 'same'=>'email'] ],
        [ 'privacy', '同意が必要です。', ['exist'] ],
    ],

    /**
     * 宛先メール
     */
    'admin_mail' => [
        'to' => '',
        'subject' => 'Webサイトのお問い合わせフォームからお問い合わせがありました',
        'from' => '',
        'from_name' => '',
        'cc' => [],
        'bcc' => [],
    ],
    
    /**
     * 自動返信メール
     */
    'reply_mail' => [
        'to' => '{email}', // 直接メールアドレス or 送信値を利用する場合は{キー}を指定
        'subject' => '（自動返信）Webサイトへのお問い合わせありがとうございます',
        'from' => '',
        'from_name' => '',
        'cc' => [],
        'bcc' => [],
    ],
];