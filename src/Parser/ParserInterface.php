<?php

namespace OlekPhp\Bundle\MonologBundle\Parser;

use OlekPhp\Bundle\MonologBundle\Model\LogLine;

interface ParserInterface
{
    public function parse(string $line, ?string $dateFormat, int $days, string $pattern, bool $jsonAsText, bool $jsonFailSoft): ?LogLine;

}