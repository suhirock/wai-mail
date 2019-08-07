<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>バリデートテスト</title>
</head>
<body>
<?php
require_once 'wai-validation.class.php';
$_vali = new waiValidation();
$_vali->set_target(
    array(
        'name' => 'テスト太郎',
        'email' => 'test@text.com',
        'tel' => '',
    )
);
$_vali->rule('name',['exist']);
$_vali->rule('email',['exist','email']);
$_vali->isError();
?>
</body>
</html>
