<?php

use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Exception\MarkdownException;
use Ethanrobins\Chatbridge\Language\LangDriver;
use Ethanrobins\Chatbridge\Processing\MarkdownDriver;
use Ethanrobins\Chatbridge\Utils;

require __DIR__ . '/../vendor/autoload.php';

Utils::showConstruction();
Utils::phpInit();
$lang = LangDriver::getStoredLang();

$file = $_GET['file'] ?? null;

try {
    $absolutePath = MarkdownDriver::checkMd($file);
} catch (MarkdownException $e) {
    echo $e->getDetails() . "<br>";
    die($e->getMessage());
}

// TODO: Build the driver with MarkdownDriver class.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php echo Utils::headInit(); ?>
    <title>Document</title>
</head>
<body>
    <?php
    echo LangDriver::getLangModal();
    try {
        echo MarkdownDriver::getNav($absolutePath);
    } catch (DocumentationConfigurationException|MarkdownException $e) {
        print_r($e);
    }
    ?>
</body>
</html>
