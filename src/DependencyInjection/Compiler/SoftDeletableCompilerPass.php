<?php
/**
 * Created by PhpStorm.
 * User: Zogxray (Viktor Pavlov)
 * Date: 31.08.18
 * Time: 10:07
 */

namespace Zogxray\SoftDeletableBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SoftDeletableCompilerPass
 * @package Zogxray\SoftDeletableBundle\DependencyInjection\Compiler
 */
class SoftDeletableCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $ormConnections = $container->getParameter('doctrine.connections');

        $connections = $container->getParameter('softDelete.connections');

        foreach ($connections as $key => $connection) {

            if (!in_array($key, array_keys($ormConnections)))
            {
                continue;
            }

            $container->getDefinition('doctrine.orm.'.$key.'_configuration')
                ->addMethodCall('addFilter', ['softDelete', $connection['filter']]);

            $filters = $container
                ->getDefinition('doctrine.orm.'.$key.'_manager_configurator')
                ->getArgument(0);

            /** Push new filter, not overwrite global config */
            if (is_array($filters)) {
                $filters[] = 'softDelete';

                $container
                    ->getDefinition('doctrine.orm.'.$key.'_manager_configurator')
                    ->replaceArgument(0, $filters);
            }
        }
    }
}
