<?php
namespace Ethanrobins\Chatbridge\Processing;

use Ethanrobins\Chatbridge\Config\RootConfig;
use Ethanrobins\Chatbridge\Exception\MarkdownException;
use Ethanrobins\Chatbridge\Utils;

class MarkdownDriver
{
    /**
     * Verifies a .md file is readable.
     * @param string|null $path Path from web root
     * @return string The absolute path to .md file. No return if failed.
     * @throws \Exception
     */
    public static function checkMd(string|null $path) :string
    {
        if (!$path) {
            http_response_code(400);
            throw new MarkdownException("Bad Request: No file specified.");
        }

        $path = ltrim($path, '/');
        $filePath = __DIR__ . 'MarkdownDriver.php/' . $path;

        if (str_contains($path, 'markdown_driver')) {
            http_response_code(403);
            throw new MarkdownException("403 Forbidden: The requested file has been disallowed.", 0, null, $filePath);
        }

        if (!file_exists($filePath)) {
            http_response_code(404);
            throw new MarkdownException("404 Not Found: The requested file does not exist.", 0, null, $filePath);
        }

        if (!is_readable($filePath)) {
            $errorCode = 403;
            http_response_code($errorCode);
            throw new MarkdownException("403 Forbidden: The requested file is not accessible.", $errorCode, null, $filePath);
        }

        echo "200 File Accessible: " . htmlspecialchars($filePath);
        return $filePath;
    }

    /**
     * Builds and returns the navigation based on the page's config.json and internal headings.
     * @param string $path Absolute path to .md file. Recommended to use {@link MarkdownDriver::checkMd()}
     * @return string The processed navigation in HTML format.
     */
    public static function getNav(string $path) :string
    {
        $configPath = Utils::getConfigPath($path);

        $config = RootConfig::fromConfig($configPath);

        ob_start();

        echo "<pre>" . print_r($config, true) . "</pre>";
        // TODO: work on doc navigation

        return ob_get_clean();
    }
}