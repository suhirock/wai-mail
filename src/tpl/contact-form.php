
<?php
/**
 * contact form
 */
require_once __DIR__.'/common-header.php';
?>
<h1>お問い合わせフォーム</h1>
<form action="./confirm" method="post">
    <input type="hidden" name="<?php echo $csrfkey; ?>" value="<?php echo $csrf; ?>">
    <div>
        <label>お名前</label>
        <input type="text" name="name" value="<?php echo $_util->form_value(@$param['post']['name']); ?>">
        <?php echo $_util->error_value(@$errors['name']); ?>
    </div>
    <div>
        <label>ふりがな</label>
        <input type="text" name="kana" value="<?php echo $_util->form_value(@$param['post']['kana']); ?>">
    </div>
    <div>
        <label>メールアドレス</label>
        <input type="email" name="email" value="<?php echo $_util->form_value(@$param['post']['email']); ?>">
        <?php echo $_util->error_value(@$errors['email']); ?>
    </div>
    <div>
        <label>メールアドレス確認</label>
        <input type="email" name="email2" value="<?php echo $_util->form_value(@$param['post']['email2']); ?>">
        <?php echo $_util->error_value(@$errors['email2']); ?></div>
    <div>
        <label>内容</label>
        <textarea name="body"><?php echo $_util->form_value(@$param['post']['body']); ?></textarea>
    </div>
    <div>
        <label><input type="checkbox" name="privacy" value="1"<?php echo $_util->check_one_value(@$param['post']['privacy']); ?>>同意する</label><?php echo $_util->error_value(@$errors['privacy']); ?>
    </div>
    <div><input type="submit" value="確認"></div>
</form>
<?php
require_once __DIR__.'/common-footer.php';