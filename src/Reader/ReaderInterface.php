<?php

namespace TaxiAdmin\Bundle\MonologReaderBundle\Reader;

use TaxiAdmin\Bundle\MonologReaderBundle\Parser\ParserInterface;

interface ReaderInterface
{
    public function setParser(ParserInterface $parser);
}