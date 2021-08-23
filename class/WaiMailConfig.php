<?php
/**
 * Config
 * 
 * .1.3
 */
$Config = [
    /**
     * URL setting
     * 
     * confirm
     * complete
     */
    'confirm' => 'confirm',
    'complete' => 'complete',

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
        'mail_to' => '',
        'mail_from' => '',
        'mail_from_name' => '',
        'mail_cc' => [],
        'mail_bcc' => [],
    ],
    
    /**
     * 自動返信メール
     */
    'reply_mail' => [
        'mail_to' => '',
        'mail_from' => '',
        'mail_from_name' => '',
        'mail_cc' => [],
        'mail_bcc' => [],
    ],
];