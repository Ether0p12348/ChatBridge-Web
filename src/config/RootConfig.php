<?php

namespace Ethanrobins\Chatbridge\Config;

use Ethanrobins\Chatbridge\Exception\DocumentationConfigurationException;
use Ethanrobins\Chatbridge\Exception\InaccessibleFileException;
use Ethanrobins\Chatbridge\Language\LangDriver;
use Ethanrobins\Chatbridge\Utils;

/**
 * Represents the root data for the documentation.
 */
class RootConfig extends DocConfig
{
    /**
     * @var array The array of root-level pages.
     */
    private array $pages;
    /**
     * @var array The array of static pages shown globally site-wide.
     */
    private array $staticPages;

    /**
     * Constructs the root documentation.
     *
     * @param string $title The title of the documentation.
     * @param string $path The root's home.md path.
     * @param array $pages The nested pages or sections at the root level.
     * @throws DocumentationConfigurationException
     * @throws InaccessibleFileException
     */
    public function __construct(string $title, string $path, array $pages) {
        parent::__construct($title, $path);
        $this->type = Type::ROOT;
        if (!empty($pages)) {
            $this->pages = $pages;
        }

        $activeLang = LangDriver::getStoredLang();

        try {
            $rootConfigFile = Utils::checkFile($_SERVER['DOCUMENT_ROOT'] . "/global_docs" . str_replace('-', '_', $activeLang->getLocale()) . "/config.json", $_SERVER['DOCUMENT_ROOT'] . "/global_docs/en_US/config.json");
        } catch (InaccessibleFileException $e) {
            die("No global config.json found: " . $e->getMessage());
        }

        $data = Utils::getJsonData($rootConfigFile);

        foreach ($data['static_pages'] as $p) {
            if ($p['type'] === Type::PAGE->value) {
                $this->staticPages[] = new DocConfig($p['title'], $p['path']);
            } else if ($p['type'] === Type::SECTION->value) {
                $this->staticPages[] = self::getPagesFromSection($p);
            } else {
                die("Invalid static page type: " . $p['type']);
            }
        }
    }

    /**
     * Returns the pages configured at the root level.
     *
     * @return array An array of root-level pages.
     */
    public function getPages(): array
    {
        return $this->pages;
    }

    /**
     * Returns the static pages used globally.
     *
     * @return array An array of global pages.
     */
    public function getStaticPages(): array
    {
        return $this->staticPages;
    }

    /**
     * Recursively parses nested sections and constructs their pages.
     *
     * @param array $section The section data from the configuration file.
     * @return SectionConfig The constructed section.
     * @throws InaccessibleFileException
     */
    private static function getPagesFromSection(array $section): SectionConfig
    {
        $sectionPages = [];
        foreach ($section as $p) {
            if ($p['type'] === Type::PAGE->value) {
                if (!isset($p['path']) || !isset($p['title'])) {
                    die("Missing 'path' or 'title' for page.");
                }
                $sectionPages[] = new DocConfig($p['title'], $p['path']);
            } else if ($p['type'] === Type::SECTION->value) {
                $sectionPages[] = self::getPagesFromSection($p);
            } else {
                die("Invalid page type: " . $p['type']);
            }
        }
        if (!isset($section['path']) || !isset($section['title'])) {
            die("Missing 'path' or 'title' for page.");
        }
        return new SectionConfig($section['title'], $section['path'], $sectionPages);
    }

    /**
     * Creates a new RootConfig object from the configuration JSON file.
     *
     * @param string $filePath The absolute path to the configuration JSON file.
     * @return self The constructed RootConfig instance.
     * @throws DocumentationConfigurationException
     * @throws InaccessibleFileException
     */
    public static function fromConfig(string $filePath): self
    {
        $rootConfigFile = $filePath;

        $data = Utils::getJsonData($rootConfigFile);

        $rootPages = [];
        foreach ($data['pages'] as $p) {
            if ($p['type'] === Type::PAGE->value) {
                $rootPages[] = new DocConfig($p['title'], $p['path']);
            } else if ($p['type'] === Type::SECTION->value) {
                $rootPages[] = self::getPagesFromSection($p);
            } else {
                throw new DocumentationConfigurationException("Invalid static page type: " . $p['type'], 404);
            }
        }

        return new self($data['title'], $data['path'], $rootPages);
    }
}