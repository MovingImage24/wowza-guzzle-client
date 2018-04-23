<?php

namespace Mi\Bundle\WowzaGuzzleClientBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 *
 * @author Jan Arnold jan.arnold@movingimage.com
 *
 * @codeCoverageIgnore
 */
class MiWowzaGuzzleClientExtension extends ConfigurableExtension
{
    /**
     * Configures the passed container according to the merged configuration.
     *
     * @param array            $mergedConfig
     * @param ContainerBuilder $container
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $servicesPath = __DIR__.'/../Resources/config/service';
        $loader = new XmlFileLoader($container, new FileLocator($servicesPath));

        $loader->load('service.xml');
        $loader->load('handler.xml');
        $loader->load('helper.xml');
        $loader->load('model.xml');
    }
}
