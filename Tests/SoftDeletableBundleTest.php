<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:12
 */

namespace Zogxray\SoftDeletableBundle\Tests;

use Zogxray\SoftDeletableBundle\DependencyInjection\SoftDeletableExtension;
use Zogxray\SoftDeletableBundle\SoftDeletableBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class SoftDeletableBundleTest
 * @package Zogxray\SoftDeletableBundle\Tests
 */
class SoftDeletableBundleTest extends TestCase
{
    public function testBuild()
    {
        /**@var ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        $bundle = new SoftDeletableBundle();

        $container->expects($this->once())
            ->method('addCompilerPass');

        $bundle->build($container);
    }

    public function testGetContainerExtension()
    {
        $bundle = new SoftDeletableBundle();

        $extention = $bundle->getContainerExtension();

        $this->assertInstanceOf(SoftDeletableExtension::class, $extention);
    }
}
