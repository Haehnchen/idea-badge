<?php

namespace espend\IdeaBadgeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('espend_idea_badge');

        $rootNode->
            children()
                ->scalarNode('badge_lifetime')
                    ->defaultValue(3600)
                ->end()
                ->scalarNode('route_path')
                    ->defaultValue('/badge/{id}/{provider}')
                ->end()
                ->scalarNode('badge_controller')
                    ->defaultValue('espend_idea_badge_bundle.badge.controller:showAction')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
