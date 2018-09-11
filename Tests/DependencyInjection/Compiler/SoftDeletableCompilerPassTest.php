<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:14
 */

namespace Zogxray\SoftDeletableBundle\Tests\DependencyInjection\Compiler;

use Zogxray\SoftDeletableBundle\DependencyInjection\Compiler\SoftDeletableCompilerPass;
use Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber\SoftDeleteSubscriber;
use Zogxray\SoftDeletableBundle\Doctrine\Filters\SoftDeleteFilter;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class SoftDeletableCompilerPassTest
 * @package Zogxray\SoftDeletableBundle\Tests\DependencyInjection\Compiler
 */
class SoftDeletableCompilerPassTest extends TestCase
{
    public function testProcess()
    {
        /**@var ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        /**@var Definition|\PHPUnit_Framework_MockObject_MockObject $definition */
        $definition = $this->createMock(Definition::class);

        $compilerPass = new SoftDeletableCompilerPass();

        $container->expects($this->at(0))
            ->method('getParameter')
            ->willReturn([
                "one" => "test.test.one_connection",
                "two" => "test.test.two_connection"
            ]);

        $container->expects($this->at(1))
            ->method('getParameter')
            ->willReturn([
                "one" => [
                    "filter" => SoftDeleteFilter::class,
                    "subscriber" => SoftDeleteSubscriber::class
                ],
                "fail_two" => [
                    "filter" => SoftDeleteFilter::class,
                    "subscriber" => SoftDeleteSubscriber::class
                ]
            ]);

        $container->expects($this->any())
            ->method('getDefinition')
            ->willReturn($definition);

        $definition->expects($this->once())
            ->method('addMethodCall');

        $definition->expects($this->once())
            ->method('getArgument')
            ->willReturn(['someFilter']);

        $definition->expects($this->once())
            ->method('replaceArgument');

        $compilerPass->process($container);
    }

    public function testProcessKeyFail()
    {
        /**@var ContainerBuilder|\PHPUnit_Framework_MockObject_MockObject $container */
        $container = $this->createMock(ContainerBuilder::class);

        $compilerPass = new SoftDeletableCompilerPass();

        $container->expects($this->at(0))
            ->method('getParameter')
            ->willReturn([
                "one" => "test.test.one_connection",
                "two" => "test.test.two_connection"
            ]);

        $container->expects($this->at(1))
            ->method('getParameter')
            ->willReturn([
                "fail_one" => [
                    "filter" => SoftDeleteFilter::class,
                    "subscriber" => SoftDeleteSubscriber::class
                ],
                "fail_two" => [
                    "filter" => SoftDeleteFilter::class,
                    "subscriber" => SoftDeleteSubscriber::class
                ]
            ]);

        $compilerPass->process($container);
    }
}
