<?php

namespace Ethanrobins\Chatbridge\Config;

use Ethanrobins\Chatbridge\Exception\InaccessibleFileException;

/**
 * Represents a section in the configuration, containing multiple nested pages or sections.
 */
class SectionConfig extends DocConfig
{
    /**
     * @var array The array of pages or sections within this section.
     */
    private array $pages;

    /**
     * Constructs a new section configuration.
     *
     * @param string $title The title of the section.
     * @param string $path The path to the section home.md.
     * @param array $pages The nested pages or sections.
     * @param string|null $link The link to get to this page.
     * @throws InaccessibleFileException
     */
    public function __construct(string $title, string $path, array $pages, ?string $link = null) {
        parent::__construct($title, $path, $link);
        $this->type = Type::SECTION;

        if (!empty($pages)) {
            $this->pages = $pages;
        }
    }

    /**
     * Returns the pages or subsections belonging to this section.
     *
     * @return array An array of pages or sections.
     */
    public function getPages(): array
    {
        return $this->pages;
    }
}