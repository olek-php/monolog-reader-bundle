<?php

namespace OlekPhp\Bundle\MonologBundle\DependencyInjection;

use OlekPhp\Bundle\MonologBundle\Service\LogList;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class MonologReaderExtension extends Extension
{

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container
            ->setDefinition(LogList::class, new Definition(LogList::class))
            ->addArgument(new Reference("parameter_bag"))
            ->addArgument($config["line_pattern"])
            ->addArgument($config["date_format"])
        ;
    }

    public function getAlias(): string
    {
        return "monolog_reader_bundle";
    }
}