<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:15
 */

namespace Zogxray\SoftDeletableBundle\Tests\DependencyInjection;

use Zogxray\SoftDeletableBundle\DependencyInjection\SoftDeletableExtension;
use Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber\SoftDeleteSubscriber;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SoftDeletableExtensionTest
 * @package Zogxray\SoftDeletableBundle\Tests\DependencyInjection
 */
class SoftDeletableExtensionTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testLoad()
    {
        $container = new ContainerBuilder();

        $config = ['soft_delete' => ['connections' => ['one' => [], 'two' => []]]];

        $extension = new SoftDeletableExtension();

        $extension->load($config, $container);

        $this->assertInstanceOf(SoftDeleteSubscriber::class, $container->get('soft_delete.one.subscriber'));
        $this->assertInstanceOf(SoftDeleteSubscriber::class, $container->get('soft_delete.two.subscriber'));

        $this->assertEquals(2, count($container->findTaggedServiceIds('doctrine.event_subscriber')));
        $this->assertEquals(2, count($container->getParameter('softDelete.connections')));
    }

    public function testGetAlias()
    {
        $extension = new SoftDeletableExtension();
        $this->assertEquals('soft_delete', $extension->getAlias());
    }
}
