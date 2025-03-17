<?php
namespace Ethanrobins\Chatbridge\Processing;

use Ethanrobins\Chatbridge\Config\RootConfig;
use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Exception\InaccessibleFileException;
use Ethanrobins\Chatbridge\Exception\MarkdownException;
use Ethanrobins\Chatbridge\Utils;

/**
 * Utility class for Markdown static methods.
 */
class MarkdownDriver
{
    /**
     * @var bool {@link MarkdownDriver::getNav()} should only be called once per page load. This ensures that's true.
     */
    static private bool $navRetrieved = false;
    /**
     * Gets whether {@link MarkdownDriver::getNav()} has been called already using {@link MarkdownDriver::$navRetrieved}.
     * @return bool
     */
    static private function navRetrieved(): bool
    {
        return self::$navRetrieved;
    }

    /**
     * Verifies a .md file is readable.
     * @param string|null $path Path from web root
     * @param string|null $fallbackPath Fallback path from web root - the file to be used if original is inaccessible.
     * @return string The absolute path to .md file. No return if failed.
     * @throws MarkdownException
     * @throws InaccessibleFileException
     */
    public static function checkMd(?string $path, ?string $fallbackPath = null) :string
    {
        if (!$path) {
            throw new MarkdownException("Bad Request: No file specified.", 400);
        }

        $path = ltrim($path, '/');
        $filePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $path;

        $fallbackPath = ltrim($fallbackPath, '/');
        $fallbackFilePath = $_SERVER['DOCUMENT_ROOT'] . '/' . $fallbackPath;

        if (str_contains($path, 'markdown_driver')) {
            throw new MarkdownException("403 Forbidden: The requested file has been disallowed.", 403, null, $filePath);
        }

        return Utils::checkFile($filePath, $fallbackFilePath);
    }

    /**
     * Builds and returns the navigation based on the page's config.json and internal headings.
     * @param string $path Absolute path to .md file. Recommended to use {@link MarkdownDriver::checkMd()}
     * @return string The processed navigation in HTML format.
     * @throws DocumentationConfigurationException
     * @throws InaccessibleFileException
     */
    public static function getNav(string $path) :string
    {
        if (!self::$navRetrieved) {
            $configPath = Utils::getConfigPath($path);

            $config = RootConfig::fromConfig($configPath);

            ob_start();

            echo "<pre>" . print_r($config, true) . "</pre>";
            // TODO: work on doc navigation

            self::$navRetrieved = true;
            return ob_get_clean();
        }
        return "";
    }
}