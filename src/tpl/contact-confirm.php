<h1>お問い合わせフォーム</h1>
<form action="./confirm" method="post">
    <input type="hidden" name="<?php echo $csrfkey; ?>" value="<?php echo $csrf; ?>">
    <div>
        <label>お名前</label>
        <?php echo $this->confirm_value($param['post']['name']); ?>
    </div>
    <div>
        <label>ふりがな</label>
        <?php echo $this->confirm_value($param['post']['kana'],'-'); ?>
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