<?php
/**
 * 読み込み
 */
if(empty($_SERVER['HTTP_REFERER'])){
    header('Location:./');
}
require_once __DIR__.'/contact.php';
