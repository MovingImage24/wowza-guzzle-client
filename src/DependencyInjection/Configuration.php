<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see
 * {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 *
 * @author Jan Arnold jan.arnold@movingimage.com
 *
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();

        $rootNode = $treeBuilder->root('parameters');
        $rootNode
            ->children()
            ->arrayNode('mi_wowza_guzzle_client')
            ->children()
            ->scalarNode('wowza_admin')->isRequired()->end()
            ->scalarNode('wowza_admin_password')->isRequired()->end()
            ->scalarNode('wowza_protocol')->defaultValue('http')->isRequired()->end()
            ->scalarNode('wowza_hostname')->defaultValue('localhost')->isRequired()->end()
            ->scalarNode('wowza_dvr_port')->defaultValue('8086')->isRequired()->end()
            ->scalarNode('wowza_app')->defaultValue('wowza-app')->isRequired()->end()
            ->end();

        return $treeBuilder;
    }
}
