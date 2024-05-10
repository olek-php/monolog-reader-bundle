<?php

namespace OlekPhp\Bundle\MonologBundle\Model;

class LogFile
{
    private int $id = 0;
    private string $path;
    private string $name;
    private int $days = 0;
    private ?string $pattern = null;
    private ?string $dateFormat = null;
    private array $levels = [
        "debug" => "DEBUG",
        "info" => "INFO",
        "notice" => "NOTICE",
        "warning" => "WARNING",
        "error" => "ERROR",
        "alert" => "ALERT",
        "critical" => "CRITICAL",
        "emergency" => "EMERGENCY",
    ];
    private ?int $size = null;
    private ?string $mTime = null;
    private bool $exists = true;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): void
    {
        $this->path = $path;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDays(): int
    {
        return $this->days;
    }

    public function setDays(int $days): void
    {
        $this->days = $days;
    }

    public function getPattern(): ?string
    {
        return $this->pattern;
    }

    public function setPattern(?string $pattern): void
    {
        $this->pattern = $pattern;
    }

    public function getDateFormat(): ?string
    {
        return $this->dateFormat;
    }

    public function setDateFormat(?string $dateFormat): void
    {
        $this->dateFormat = $dateFormat;
    }

    public function getLevels(): array
    {
        return $this->levels;
    }

    public function setLevels(array $levels): void
    {
        $this->levels = $levels;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    public function getMTime(): ?string
    {
        return $this->mTime;
    }

    public function setMTime(?string $mTime): void
    {
        $this->mTime = $mTime;
    }

    public function isExists(): bool
    {
        return $this->exists;
    }

    public function setExists(bool $exists): void
    {
        $this->exists = $exists;
    }
}