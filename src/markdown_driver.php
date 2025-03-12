<?php

use Ethanrobins\Chatbridge\Exception\MarkdownException;
use Ethanrobins\Chatbridge\Processing\MarkdownDriver;
use Ethanrobins\Chatbridge\Utils;

require __DIR__ . '/../vendor/autoload.php';

Utils::displayErrors();

$file = $_GET['file'] ?? null;

echo $file . "<br>";

try {
    $absolutePath = MarkdownDriver::checkMd($file);
} catch (MarkdownException $e) {
    echo $e->getDetails() . "<br>";
    die($e->getMessage());
}

echo "<br>" . $absolutePath . "<br>";

echo MarkdownDriver::getNav($absolutePath);

// TODO: Build the driver with with MarkdownDriver class.

