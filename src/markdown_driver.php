<?php
use Ethanrobins\Chatbridge\MarkdownDriver;

require __DIR__ . '/../vendor/autoload.php';

$file = $_GET['file'] ?? null;

MarkdownDriver::checkMd($file);

// TODO: Build the driver in conjecture with MarkdownDriver class.