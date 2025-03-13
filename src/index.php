<?php

use Ethanrobins\Chatbridge\Utils;

require __DIR__ . '/../vendor/autoload.php';

$langHeader = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

// TODO: Use Ethanrobins\Chatbridge\Language\* for link embed translation
// TODO: Use Ethanrobins\Chatbridge\Language\* for page translation
$title = "ChatBridge - Message Translator for Discord";
$description = "A Discord application designed to break language barriers with seamless, context-aware message translation. 

Powered by ChatGPT, it preserves tone, intent, and nuance for natural communication.

Our mission is to create a more connected and inclusive online community where language differences no longer hinder conversations.";
$url = "https://chatbridge.app";
$image = "https://chatbridge.app/assets/chatbridge/icon.png";
$image_type = "image/png";
$image_alt = "ChatBridge Icon";
$color = "#228fef";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <meta content="<?php echo $title; ?>" property="og:title" lang="en"/>
    <meta content="<?php echo $description; ?>" property="og:description" lang="en"/>
    <meta content="<?php echo $url; ?>" property="og:url"/>
    <meta content="<?php echo $image; ?>" property="og:image"/>
    <meta content="<?php echo $image_type ?>" property="og:image:type"/>
    <meta content="<?php echo $image_alt ?>" property="og:image:alt"/>
    <meta content="<?php echo $color; ?>" data-react-helmet="true" name="theme-color"/>
    <meta content="ChatBridge" property="og:site_name"/>

    <?php echo Utils::init(); ?>
    <title><?php echo $title; ?></title>
</head>
<body>
    <?php print_r($langHeader); ?>
</body>
</html>
