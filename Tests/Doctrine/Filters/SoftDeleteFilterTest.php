<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:25
 */

namespace Zogxray\SoftDeletableBundle\Tests\Doctrine\Filters;

use Doctrine\ORM\EntityManagerInterface;
use Zogxray\SoftDeletableBundle\Doctrine\Filters\SoftDeleteFilter;
use Zogxray\SoftDeletableBundle\Tests\Doctrine\Stubs\SoftDeletableClass;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Mapping\ClassMetadata;
use ReflectionClass;


/**
 * Class SoftDeleteFilterTest
 * @package Zogxray\SoftDeletableBundle\Tests\Doctrine\Filters
 */
class SoftDeleteFilterTest extends TestCase
{
    /**
     * @throws \ReflectionException
     */
    public function testAddFilterConstraintNoInterface()
    {
        /**@var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        /**@var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject $classMetadata */
        $classMetadata = $this->createMock(ClassMetadata::class);

        $softDeleteFilter = new SoftDeleteFilter($entityManager);

        $classMetadata->expects($this->once())
            ->method('getReflectionClass')
            ->willReturn(new ReflectionClass(\stdClass::class));

        $classMetadata->expects($this->never())
            ->method('hasField');

        $result = $softDeleteFilter->addFilterConstraint($classMetadata, 'test');

        $this->assertEmpty( $result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddFilterConstraintNoField()
    {
        /**@var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        /**@var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject $classMetadata */
        $classMetadata = $this->createMock(ClassMetadata::class);

        $softDeleteFilter = new SoftDeleteFilter($entityManager);

        $classMetadata->expects($this->once())
            ->method('getReflectionClass')
            ->willReturn(new ReflectionClass(SoftDeletableClass::class));

        $classMetadata->expects($this->once())
            ->method('hasField')
            ->willReturn(false);

        $result = $softDeleteFilter->addFilterConstraint($classMetadata, 'test');

        $this->assertEmpty($result);
    }

    /**
     * @throws \ReflectionException
     */
    public function testAddFilterConstraint()
    {
        /**@var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        /**@var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject $classMetadata */
        $classMetadata = $this->createMock(ClassMetadata::class);

        $softDeleteFilter = new SoftDeleteFilter($entityManager);

        $classMetadata->expects($this->once())
            ->method('getReflectionClass')
            ->willReturn(new ReflectionClass(SoftDeletableClass::class));

        $classMetadata->expects($this->once())
            ->method('hasField')
            ->willReturn(true);

        $classMetadata->expects($this->once())
            ->method('getColumnName')
            ->willReturn('deletedAt');

        $result = $softDeleteFilter->addFilterConstraint($classMetadata, 'test');

        $this->assertEquals('test.deletedAt IS NULL', $result);
    }
}