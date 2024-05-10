<?php

namespace OlekPhp\Bundle\MonologBundle\Reader;

use Exception;
use OlekPhp\Bundle\MonologBundle\Model\LogLine;
use RuntimeException;
use SplFileObject;
use OlekPhp\Bundle\MonologBundle\Model\LogFile;

class Reader extends AbstractReader
{
    protected LogFile $log;
    protected SplFileObject $file;
    protected int $lineCount;

    public int $days;
    public string $pattern;
    public ?string $dateFormat;


    public function __construct(LogFile $log, string $pattern = "default")
    {
        $this->log = $log;
        $this->file = new SplFileObject($log->getPath(), 'r');
        $i = 0;
        while (!$this->file->eof()) {
            $this->file->current();
            $this->file->next();
            $i++;
        }

        $this->days = $log->getDays();
        $this->pattern = $pattern;
        $this->dateFormat = $log->getDateFormat();

        $this->lineCount = $i;

        parent::__construct();
    }

    public function setPattern(string $pattern = "default"): self
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->lineCount < $offset;
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function offsetGet($offset): ?LogLine
    {
        $key = $this->file->key();
        $this->file->seek($offset);
        $log = $this->current();
        $this->file->seek($key);
        $this->file->current();

        return $log;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        throw new RuntimeException("LogReader is read-only.");
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        throw new RuntimeException("LogReader is read-only.");
    }

    /**
     * {@inheritdoc}
     */
    public function rewind(): void
    {
        $this->file->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function next(): void
    {
        $this->file->next();
    }

    /**
     * {@inheritdoc}
     * @throws Exception
     */
    public function current(): ?LogLine
    {
        return $this->getParser()->parse($this->file->current(), $this->dateFormat, $this->days, $this->pattern, '');
    }

    /**
     * {@inheritdoc}
     */
    public function key(): int
    {
        return $this->file->key();
    }

    /**
     * {@inheritdoc}
     */
    public function valid(): bool
    {
        return $this->file->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function count(): int
    {
        return $this->lineCount;
    }
}