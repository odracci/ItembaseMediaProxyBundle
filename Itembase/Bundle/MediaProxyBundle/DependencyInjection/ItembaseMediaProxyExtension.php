<?php

namespace Itembase\Bundle\MediaProxyBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 *
 */
class ItembaseMediaProxyExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('ib_media_proxy.algorithm', $config['algorithm']);
        $container->setParameter('ib_media_proxy.secret', $config['secret']);
        $container->setParameter('ib_media_proxy.ignore_https', $config['ignore_https']);
        $container->setParameter('ib_media_proxy.prefix_path', $config['prefix_path']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}