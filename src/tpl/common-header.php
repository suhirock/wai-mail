<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo @$title; ?></title>
    <?php if(!empty($keyword)){ ?><meta name="keywords" content="<?php echo @$keyword; ?>"><?php } ?>
    <?php if(!empty($description)){ ?><meta name="description" content="<?php echo @$description; ?>"><?php } ?>
</head>
<body>