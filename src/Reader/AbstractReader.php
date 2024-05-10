<?php

namespace OlekPhp\Bundle\MonologBundle\Reader;

use ArrayAccess;
use Countable;
use Iterator;
use OlekPhp\Bundle\MonologBundle\Parser\Parser;
use OlekPhp\Bundle\MonologBundle\Parser\ParserInterface;

abstract class AbstractReader implements ReaderInterface, Iterator, ArrayAccess, Countable
{
    private ParserInterface $parser;

    public function __construct()
    {
        $this->parser = new Parser();
    }

    public function getParser(): ParserInterface
    {
        return $this->parser;
    }

    public function setParser(ParserInterface $parser): self
    {
        $this->parser = $parser;

        return $this;
    }
}