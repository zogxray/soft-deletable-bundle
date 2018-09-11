<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:09
 */

namespace Zogxray\SoftDeletableBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Class SoftDeletableExtension
 * @package Zogxray\SoftDeletableBundle\DependencyInjection
 */
class SoftDeletableExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('softDelete.connections', $config['connections']);

        foreach ($config['connections'] as $key => $connection) {
            $container->register('soft_delete.'.$key.'.subscriber', $connection['subscriber'])
                ->addTag('doctrine.event_subscriber', ['connection' => $key]);
        }
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return 'soft_delete';
    }
}