<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:07
 */

namespace Zogxray\SoftDeletableBundle\DependencyInjection;

use Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber\SoftDeleteSubscriber;
use Zogxray\SoftDeletableBundle\Doctrine\Filters\SoftDeleteFilter;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Zogxray\SoftDeletableBundle\DependencyInjection
 * @codeCoverageIgnore
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree builder.
     *
     * @return TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('soft_delete');
        /** @var ArrayNodeDefinition|NodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('connections')
                    ->arrayPrototype()
                        ->children()
                            ->scalarNode('filter')
                                ->defaultValue(SoftDeleteFilter::class)
                            ->end()
                            ->scalarNode('subscriber')
                                ->defaultValue(SoftDeleteSubscriber::class)
                            ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
