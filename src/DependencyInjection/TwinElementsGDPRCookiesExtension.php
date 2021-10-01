<?php

namespace TwinElements\GDPRCookiesBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class TwinElementsGDPRCookiesExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('twin_elements_gdpr', $config);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.xml');
    }
}
