
<?php
/**
 * contact error
 */
require_once __DIR__.'/common-header.php';
?>
<h1>お問い合わせフォーム</h1>
<div class="error">
<?php
foreach( $errors as $k => $v) {
    echo '<div>'.$v.'</div>';
}
?>
</div>
<a href="./">お問い合わせTOPへ</a>
<?php
require_once __DIR__.'/common-footer.php';