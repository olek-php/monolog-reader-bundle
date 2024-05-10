<?php

namespace OlekPhp\Bundle\MonologBundle\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Finder\Finder;
use OlekPhp\Bundle\MonologBundle\Model\LogFile;

class LogList
{
    private ParameterBagInterface $parameterBag;
    private ?string $appPattern;
    private ?string $appDateFormat;

    protected array $levels = [
        "debug" => "DEBUG",
        "info" => "INFO",
        "notice" => "NOTICE",
        "warning" => "WARNING",
        "error" => "ERROR",
        "alert" => "ALERT",
        "critical" => "CRITICAL",
        "emergency" => "EMERGENCY",
    ];

    public function __construct(
        ParameterBagInterface $parameterBag,
        ?string $appPattern = null,
        ?string $appDateFormat = null
    )
    {
        $this->parameterBag = $parameterBag;
        $this->appPattern = $appPattern;
        $this->appDateFormat = $appDateFormat;
    }

    /**
     * @return LogFile[]
     */
    public function getLogList(): array
    {
        $logs = [];
        $id = 0;

        $finder = new Finder();
        $finder->files()->in($this->parameterBag->get('kernel.logs_dir'));
        foreach ($finder as $file) {
            $l = new LogFile();
            $l->setId($id);
            $l->setName($file->getFilename());
            $l->setPath($file->getRealPath());
            $l->setPattern($this->appPattern);
            $l->setDateFormat($this->appDateFormat);
            $l->setExists(true);
            $l->setLevels($this->levels);
            $l->setSize($file->getSize());
            $l->setMTime($file->getMTime());
            $logs[] = $l;
            $id++;
        }

        return $logs;
    }
}