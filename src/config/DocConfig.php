<?php

namespace Ethanrobins\Chatbridge\Config;

use Ethanrobins\Chatbridge\Exception\MarkdownException;

/**
 * Represents a general configuration item such as a page or section.
 */
class DocConfig
{
    /**
     * @var array Stores navigation items created during runtime.
     */
    private static array $navItems = [];

    /**
     * @var Type The type of the navigation item (e.g., page, section).
     */
    protected Type $type;
    /**
     * @var string The page title.
     */
    private string $title;
    /**
     * @var string The path to the local .md file.
     */
    private string $path;

    /**
     * Constructs a new configuration item.
     *
     * @param string $title The page title.
     * @param string $path The path to the local .md file.
     * @throws MarkdownException
     */
    public function __construct(string $title, string $path) {
        $this->type = Type::PAGE;
        $this->title = $title;
        $this->path = $path;

        if (!file_exists($this->getAbsolutePath())) {
            throw new MarkdownException("404 Not Found: " . $this->getAbsolutePath() . " does not exist!", 404);
        }
        if (!is_readable($this->getAbsolutePath())) {
            throw new MarkdownException("403 Forbidden: " . $this->getAbsolutePath() . " is not readable!", 403);
        }

        self::$navItems[] = $this;
    }

    /**
     * Returns the type of the navigation item.
     *
     * @return Type The item's type.
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Returns the title of the page.
     *
     * @return string The page's title.
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Returns the file path for the .md file.
     *
     * @return string The item's path.
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * Returns the absolute file path based on the document root and the item's path.
     *
     * @return string The absolute path.
     */
    public function getAbsolutePath(): string
    {
        return $_SERVER['DOCUMENT_ROOT']. "/" . trim($this->path, "/");
    }

    /**
     * Returns all navigation items created during runtime.
     *
     * @return array An array of navigation items.
     */
    public static function getNavItems(): array
    {
        return self::$navItems;
    }
}