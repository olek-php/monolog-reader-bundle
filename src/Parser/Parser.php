<?php

namespace OlekPhp\Bundle\MonologBundle\Parser;

use DateTime;
use DateTimeImmutable;
use Exception;
use OlekPhp\Bundle\MonologBundle\Model\LogLine;
use RuntimeException;

class Parser implements ParserInterface
{

    public const PATTERN_MONOLOG2 =
        "/^" . // start with newline
        "\[(?<date>.*)\] " . // find the date that is between two brackets []
        "(?<channel>[\w-]+).(?<level>\w+): " . // get the channel and log level, they look lilke this: channel.ERROR, follow by colon and space
        "(?<message>[^\[\{\\n]+)" . // next up is the message (containing anything except [ or {, nor a new line)
        "(?:(?<context> (\[.*?\]|\{.*?\}))|)" . // followed by a space and anything (non-greedy) in either square [] or curly {} brackets, or nothing at all (skips ahead to line end)
        "(?:(?<extra> (\[.*\]|\{.*\}))|)" . // followed by a space and anything (non-greedy) in either square [] or curly {} brackets, or nothing at all (skips ahead to line end)
        "\s{0,2}$/m"; // end with up to 2 optional spaces and the endline marker, flag: m = multiline

    public const PATTERN_MONOLOG2_MULTILINE = // same as PATTERN_MONOLOG2 except for annotated changed
        "/^" .
        "\[(?<date>[^\]]*)\] " . // allow anything until the first closing bracket ]
        "(?<channel>[\w-]+).(?<level>\w+): " .
        "(?<message>[^\[\{]+)" . // allow \n character in message string
        "(?:(?<context> (\[.*?\]|\{.*?\}))|)" .
        "(?:(?<extra> (\[.*?\]|\{.*?\}))|)" . // . has to be non-greedy so it doesn't take everything in
        "\s{0,2}$" .
        "(?=\\n(?:\[|\z))" . // use look-ahead to match (a) a following newline and opening bracket [ (that would signal the next log entry)
        "/ms"; // flags: m = multiline, s = . includes newline character

    protected array $pattern = [
        "default" => self::PATTERN_MONOLOG2,
        "multiline" => self::PATTERN_MONOLOG2_MULTILINE
    ];

    /**
     * @throws Exception
     */
    public function parse(
        string $line,
        ?string $dateFormat,
        int $days = 0,
        string $pattern = "default",
        bool $jsonAsText = false,
        bool $jsonFailSoft = true
    ): ?LogLine
    {
        if ($line === "") {
            return null;
        }
        preg_match($this->pattern[$pattern], $line, $data);
        if (!isset($data["date"])) {
            return null;
        }

        $date = null;
        if ($dateFormat === null) {
            try {
                $date = new DateTimeImmutable($data["date"]);
            } catch (Exception $e) {
            }
        } else {
            $date = DateTimeImmutable::createFromFormat($dateFormat, $data["date"]);
        }

        $result = new LogLine();
        $result->createdAt = $date;
        $result->channel   = $data['channel'] ?? "";
        $result->level     = $data['level'] ?? "";
        $result->message   = trim($data["message"] ?? "");
        $result->context   = $this->processJson($data["context"] ?? "[]");
        $result->extra     = $this->processJson($data["extra"] ?? "[]");


        if (0 === $days) {
            return $result;
        }
        if ($date instanceof DateTime) {
            $d2 = new DateTime('now');

            if ($date->diff($d2)->days < $days) {
                return $result;
            }

            return null;
        }
        return null;
    }

    /**
     * @throws RuntimeException
     */
    public function registerPattern(string $name, string $pattern): void
    {
        if (!isset($this->pattern[$name])) {
            $this->pattern[$name] = $pattern;
        } else {
            throw new RuntimeException("Pattern $name already exists");
        }
    }

    protected function processJson(string $text, bool $jsonAsText = false, bool $jsonFailSoft = true)
    {
        // replace characters to make JSON parsable
        $json = str_replace(["\r", "\n"], ['', '\n'], $text);
        if ($jsonAsText) {
            return trim($json);
        }
        $array = json_decode($json, true);

        if (($array === null) && $jsonFailSoft) {
            return trim($json);
        }
        // and let's typecast this if it's not array or object
        if (!is_array($array) && !($array instanceof \stdClass) && $array !== null) {
            // simply put it into an array
            $array = [$array];
        }
        return $array;
    }

}