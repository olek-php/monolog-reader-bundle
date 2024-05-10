<?php

namespace TaxiAdmin\Bundle\MonologReaderBundle\Parser;

interface ParserInterface
{
    public function parse(string $line, ?string $dateFormat, int $days, string $pattern, bool $jsonAsText, bool $jsonFailSoft): array;

}