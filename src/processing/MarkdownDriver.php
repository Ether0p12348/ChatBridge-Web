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
            throw new MarkdownException("Bad Request: No file specified.", 400);
        }

        $path = ltrim($path, '/');
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;

        if (str_contains($path, 'markdown_driver')) {
            throw new MarkdownException("403 Forbidden: The requested file has been disallowed.", 403, null, $filePath);
        }

        if (!file_exists($filePath)) {
            throw new MarkdownException("404 Not Found: The requested file does not exist.", 404, null, $filePath);
        }

        if (!is_readable($filePath)) {
            throw new MarkdownException("403 Forbidden: The requested file is not accessible.", 403, null, $filePath);
        }

        echo "200 File Accessible: " . htmlspecialchars($filePath);
        return $filePath;
    }

    /**
     * Builds and returns the navigation based on the page's config.json and internal headings.
     * @param string $path Absolute path to .md file. Recommended to use {@link MarkdownDriver::checkMd()}
     * @return string The processed navigation in HTML format.
     * @throws MarkdownException
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