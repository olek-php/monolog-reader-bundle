<?php

namespace OlekPhp\Bundle\MonologBundle\Model;

use DateTimeInterface;

class LogLine
{
    public ?DateTimeInterface $createdAt = null;

    public ?string $channel = null;

    public ?string $level = null;

    public ?string $message = null;

    public array $context = [];

    public array $extra = [];

}