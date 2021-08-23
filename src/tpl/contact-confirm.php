<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>確認画面：コンタクトフォーム</title>
</head>
<body>
    <h1>お問い合わせフォーム</h1>
    <form action="./confirm.php" method="post">
        <input type="hidden" name="<?php echo $csrfkey; ?>" value="<?php echo $csrf; ?>">
        <div>
            <label>お名前</label>
            <?php echo $this->confirm_value($param['post']['name']); ?>
        </div>
        <div>
            <label>ふりがな</label>
            <?php echo $this->confirm_value($param['post']['kana']); ?>
        </div>
        <div>
            <label>メールアドレス</label>
            <?php echo $this->confirm_value($param['post']['email']); ?>
        </div>
        <div>
            <label>内容</label>
            <?php echo $this->confirm_value($param['post']['body'],'-'); ?>
        </div>
        <div><input type="submit" name="back" value="戻る"></div>
        <div><input type="submit" name="send" value="送信"></div>
    </form>
</body>
</html>