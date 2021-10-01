<?php

namespace TwinElements\GDPRCookiesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('twin_elements_gdpr');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->scalarNode('cookies_policy_route')
                    ->defaultValue('cookies_policy')
                ->end()
            ->end();

        return $treeBuilder;
    }
}
