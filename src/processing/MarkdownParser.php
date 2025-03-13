<?php
namespace Ethanrobins\Chatbridge\Processing;

use Exception;
use Highlight\Highlighter;

class MarkdownParser
{
    // TODO: Static method for returning an array of headers' text (from $originalText).
    // TODO: Make sure all parsing can be escaped.
    // TODO: Copy-to-clipboard buttons for code blocks.
    // TODO:  - Make it possible to turn on/off the copy-to-clipboard button for code blocks.
    // TODO: Tags for colored text {color=000000 {text}}.
    // TODO: Text Highlighting tags {highlight=000000 {text}}.
    // TODO: Image/Video embedding tags.
    // TODO: A new line is a new line. 2 new lines is a paragraph break. line breaks can be escaped.
    // TODO: Line break tag (---)
    // TODO: Header references - give headers the ability to accept {id=namespace} (uri: https://chatbridge.app/page#id)
    private string $originalText;
    private string $workingText;

    public function __construct(string $text)
    {
        $this->originalText = $text;
        $this->workingText = $text;
    }

    /**
     * Get the original text
     * @return string
     */
    public function getOriginalText() :string
    {
        return $this->originalText;
    }

    /**
     * Get the parsed text
     * @return string
     */
    public function __toString() :string
    {
        return $this->workingText;
    }

    /**
     * Fully parse the text
     * @return void
     */
    public function parse() :void
    {
        $this->parseHeadings()->parseDecorations()->parseLists()->parseLinks();
    }

    /**
     * Parse headings # H1, ## H2, ### H3, etc.
     * @return $this
     */
    public function parseHeadings() :MarkdownParser
    {
        $callback = function($matches) {
            $level = strlen($matches[1]);
            $headingText = $matches[2];
            return "<h$level>$headingText</h$level>";
        };

        $pattern = '/^(#{1,6})\s+(.*)$/m';
        $this->workingText = preg_replace_callback($pattern, $callback, $this->workingText);

        return $this;
    }

    /**
     * Parse unordered and ordered lists.
     * <br><b>Unordered:</b> lines beginning with '-' or '*'
     * <br><b>Ordered:</b> lines beginning with a digit then a period (e.g. "1. something")
     * @return $this
     */
    public function parseLists() :MarkdownParser
    {
        $this->workingText = preg_replace_callback(
            '/^(\d+\.)\s+(.*)$/m',
            function ($matches) {
                return "<ol><li>$matches[2]</li></ol>";
            },
            $this->workingText);

        $this->workingText = preg_replace_callback(
            '/^(\-|\*)\s+(.*)$/m',
            function ($matches) {
                return "<ul><li>$matches[2]</li></ul>";
            },
            $this->workingText
        );

        $this->workingText = preg_replace('/<\/ul>\s*<ul>/', '', $this->workingText);
        $this->workingText = preg_replace('/<\/ol>\s*<ol>/', '', $this->workingText);

        return $this;
    }

    /**
     * Parse \*\*bold\*\*, \*italic\*, \_\_underline\_\_, \`code\`, \`\`\`lang`\n`code blocks\`\`\` text using a quick (non-greedy) regex.
     * @return $this
     */
    public function parseDecorations() :MarkdownParser
    {
        // code blocks ```highlighting\ncode``` TODO: make sure to ignore other formatting
        $this->workingText = preg_replace_callback(
            '/```([\w+\-.#]*)\n([\s\S]*?)```/',
            function ($matches) {
                // $matches[1] is the language string (e.g. "php", "js", etc.)
                // $matches[2] is the code block

                $language = $matches[1] ?: 'plaintext';
                $code     = $matches[2];

                // Use highlight.php to do server-side syntax highlighting
                $highlighter = new Highlighter();

                try {
                    $result = $highlighter->highlight($language, $code);

                    // $result->value contains the highlighted HTML
                    // $result->language is the auto-detected or matched language
                    return sprintf(
                        '<pre><code class="hljs %s">%s</code></pre>',
                        htmlspecialchars($result->language, ENT_QUOTES | ENT_HTML5, 'UTF-8'),
                        $result->value
                    );
                } catch (Exception $e) {
                    // If an error occurs (e.g. unsupported language), just escape & wrap.
                    $escaped = htmlspecialchars($code, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    return "<pre><code class=\"hljs\">$escaped</code></pre>";
                }
            },
            $this->workingText
        );

        // code `code` TODO: make sure to ignore other formatting
        $this->workingText = preg_replace_callback(
            '/`([^`]+)`/',
            function ($matches) {
                // Escape HTML inside inline code
                $escaped = htmlspecialchars($matches[1], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                return "<code>$escaped</code>";
            },
            $this->workingText
        );

        // bold **bold**
        $this->workingText = preg_replace(
            '/\*\*(.*?)\*\*/s',
            '<strong>$1</strong>',
            $this->workingText
        );

        // italic *italic*
        $this->workingText = preg_replace(
            '/\*(.*?)\*/s',
            '<em>$1</em>',
            $this->workingText
        );

        // underline __underline__
        $this->workingText = preg_replace(
            '/__(.*?)__/s',
            '<u>$1</u>',
            $this->workingText
        );

        return $this;
    }

    /**
     * Parse links from \[link\](url)
     * @return $this
     */
    public function parseLinks() :MarkdownParser
    {
        $pattern = '/\[(.*?)\]\((.*?)\)/';
        $replacement = '<a href="$2" target="_blank" rel="noopener">$1</a>';
        $this->workingText = preg_replace($pattern, $replacement, $this->workingText);

        return $this;
    }

    /**
     * Creates a new {@link MarkdownParser} from a .md file's path
     * @param string $path
     * @return MarkdownParser
     */
    public static function byPath(string $path) :MarkdownParser
    {
        return new MarkdownParser(file_get_contents($path));
    }
}