<?php

namespace mztx\ShinagePlayerBundle\DependencyInjection;

use mztx\ShinagePlayerBundle\Service\LocalPresentationLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class ShinagePlayerExtension extends ConfigurableExtension
{
    // note that this method is called loadInternal and not load
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $this->generateParameters($mergedConfig, $container);
    }

    protected function generateParameters($config, ContainerBuilder $container)
    {
        $container->setParameter('shinage.player.local.base_path', $config['local']['path']);
    }
}
