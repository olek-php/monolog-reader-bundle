<?php

namespace OlekPhp\Bundle\MonologBundle\Reader;

use OlekPhp\Bundle\MonologBundle\Parser\ParserInterface;

interface ReaderInterface
{
    public function setParser(ParserInterface $parser);
}