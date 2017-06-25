<?php

namespace mztx\ShinagePlayerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('shinage_player');

        $rootNode
            ->children()
                ->scalarNode('uuid')->end()
                ->arrayNode('local')
                    ->children()
                        ->booleanNode('enabled')->end()
                        ->scalarNode('path')->end()
                    ->end() // children of local
                ->end() // local
                ->arrayNode('remote')
                    ->children()
                        ->booleanNode('enabled')->end()
                        ->scalarNode('host')->end()
                        ->enumNode('protocol')
                            ->values(['http', 'https'])
                            ->end()
                        ->scalarNode('base_path')->end()
                        ->arrayNode('controller')
                            ->children()
                                ->scalarNode('heartbeat')->end()
                                ->scalarNode('presentation')->end()
                                ->scalarNode('asset')->end()
                                ->scalarNode('screenshot')->end()
                            ->end()
                        ->end() // controller
                    ->end() // children of remote
                ->end() // remote
            ->end() // root note
        ;

        return $treeBuilder;
    }
}
