<?php

namespace Crous\Bundle\BackendBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('crous_backend');
        
        $rootNode
            ->children()
                ->arrayNode('models')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('entity_class')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('manager_class')
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('form')
                                ->children()
                                    ->scalarNode('class')
                                        ->defaultNull()
                                    ->end()
                                    ->scalarNode('filter_class')
                                        ->defaultNull()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
