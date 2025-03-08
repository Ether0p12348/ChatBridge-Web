<?php
namespace Ethanrobins\Chatbridge;

class MarkdownDriver
{
    public static function checkMd(string|null $path) :true
    {
        if (!$path) {
            http_response_code(400);
            echo "Bad Request: No file specified.";
            exit;
        }

        $path = ltrim($path, '/');
        $filePath = __DIR__ . '/' . $path;

        if (str_contains($path, 'markdown_driver')) {
            http_response_code(404);
            echo "404 Not Found: The requested file does not exist.";
            exit;
        }

        if (!file_exists($filePath)) {
            http_response_code(404);
            echo "404 Not Found: The requested file does not exist.";
            exit;
        }

        if (!is_readable($filePath)) {
            http_response_code(403);
            echo "403 Forbidden: The requested file is not accessible.";
            exit;
        }

        echo "200 File Accessible: " . htmlspecialchars($filePath);
        return true;
    }

    public static function getNav(string ...$subtitles) :string
    {
        ob_start();

        // TODO: work on doc navigation

        return ob_get_clean();
    }
}