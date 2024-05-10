<?php

namespace TaxiAdmin\Bundle\MonologReaderBundle\Reader;

use ArrayAccess;
use Countable;
use Iterator;
use TaxiAdmin\Bundle\MonologReaderBundle\Parser\Parser;
use TaxiAdmin\Bundle\MonologReaderBundle\Parser\ParserInterface;

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