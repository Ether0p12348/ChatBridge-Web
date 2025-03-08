<?php
namespace Ethanrobins\Chatbridge;

/**
 * Utility class for general-purpose static methods.
 */
class Utils
{
    /**
     * Outputs a simple message indicating that Composer is set up correctly.
     *
     * @return void
     */
    public static function isWorking() {
        echo "Composer is working.";
    }

    /**
     * Reads and parses a JSON file from the given absolute file path.
     *
     * @param string $absoluteFilePath The absolute path to the JSON file.
     * @return array The parsed data from the JSON file as an associative array.
     */
    public static function getJsonData(string $absoluteFilePath): array {
        if (!file_exists($absoluteFilePath)) {
            die("File not found: " . $absoluteFilePath);
        }
        if (!is_readable($absoluteFilePath)) {
            die("File is not readable: " . $absoluteFilePath);
        }

        $jsonContents = file_get_contents($absoluteFilePath);

        if ($jsonContents === false) {
            die("Failed to read the JSON file: " . $absoluteFilePath);
        }

        $data = json_decode($jsonContents, true);

        if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
            die("Invalid JSON: ". json_last_error_msg());
        }

        return $data;
    }
}