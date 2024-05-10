<?php

namespace OlekPhp\Bundle\MonologBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('monolog_reader_bundle');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode->children()
            ->scalarNode('line_pattern')->info('See ddtraceweb/monolog-parser for patterns.')->defaultNull()->end()
            ->scalarNode('date_format')->info('PHP style date format of app log files')->defaultNull()->end()
            ->end();

        return $treeBuilder;
    }
}