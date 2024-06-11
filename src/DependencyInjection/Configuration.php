<?php

namespace PHProfiler\Symfony\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('phprofiler');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('dsn')->isRequired()->cannotBeEmpty()->end()
            ->booleanNode('enabled')->defaultTrue()->end()
            ->end();

        return $treeBuilder;
    }
}
