<?php

use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Exception\InaccessibleFileException;
use Ethanrobins\Chatbridge\Exception\MarkdownException;
use Ethanrobins\Chatbridge\Language\LangDriver;
use Ethanrobins\Chatbridge\Processing\MarkdownDriver;
use Ethanrobins\Chatbridge\Utils;

require __DIR__ . '/../vendor/autoload.php';

Utils::showConstruction();
Utils::phpInit();
$lang = LangDriver::getStoredLang();

$file = $_GET['file'] ?? null;
if ($file != null) {
    if ($file === '/privacy.md') {
        $fallbackFile = '/global_docs/en_US/privacy.md';
        $file = str_replace('/', "/global_docs/" . str_replace('-', '_', $lang->getLocale()) . "/", $file);
    } else if ($file === '/terms.md') {
        $fallbackFile = '/global_docs/en_US/terms.md';
        $file = str_replace('/', "/global_docs/" . str_replace('-', '_', $lang->getLocale()) . "/", $file);
    } else {
        $fallbackFile = preg_replace('#^/?([^/]+/)(.+)#', '/$1en_US/$2', $file); // For if there is no translated version for the activeLang
        $file = preg_replace('#^/?([^/]+/)(.+)#', '/$1' . str_replace('-', '_', $lang->getLocale()) . '/$2', $file); // docs/file.md -> docs/en_US/file.md
    }
}

try {
    $absolutePath = MarkdownDriver::checkMd($file, $fallbackFile ?? null);
} catch (MarkdownException|InaccessibleFileException $e) {
    echo $e->getDetails() . "<br>";
    die($e->getMessage() . " -> " . $e->getTraceAsString());
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
    echo "<div style='overflow: auto; height: 100vh; width: 100vw;'>";
    try {
        echo MarkdownDriver::getNav($absolutePath);
    } catch (DocumentationConfigurationException|InaccessibleFileException $e) {
        print_r($e);
    }
    echo "</div>";
    ?>
</body>
</html>
