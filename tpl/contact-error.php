<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>エラー：コンタクトフォーム</title>
</head>
<body>
    <h1>お問い合わせフォーム</h1>
    <div class="error">
    <?php
    foreach( $errors as $k => $v) {
        echo '<div>'.$v.'</div>';
    }
    ?>
    </div>
    <a href="./">お問い合わせTOPへ</a>
</body>
</html>