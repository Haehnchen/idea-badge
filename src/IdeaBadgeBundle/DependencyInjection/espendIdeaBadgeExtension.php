<?php

namespace espend\IdeaBadgeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * @author Daniel Espendiller <daniel@espendiller.net>
 */
class espendIdeaBadgeExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach(['badge_lifetime', 'route_path', 'badge_controller', 'monthly_storage_path'] as $cfg) {
            $container->setParameter('espend_idea_badge.' . $cfg, $config[$cfg]);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('poser.yml');
    }
}
