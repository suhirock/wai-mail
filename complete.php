<?php
/**
 * complete
 */
if(empty($_SERVER['HTTP_REFERER'])){
    header('Location:./');
}
require_once __DIR__.'/tpl/contact-complete.php';