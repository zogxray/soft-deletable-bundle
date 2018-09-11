<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:24
 */

namespace Zogxray\SoftDeletableBundle\Tests\Doctrine\EventSubscriber;

use Doctrine\ORM\EntityManagerInterface;
use Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber\SoftDeleteSubscriber;
use Zogxray\SoftDeletableBundle\Tests\Doctrine\Stubs\SoftDeletableClass;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class SoftDeleteSubscriberTest
 * @package Zogxray\SoftDeletableBundle\Tests\Doctrine\EventSubscriber
 */
class SoftDeleteSubscriberTest extends TestCase
{
    public function testGetSubscribedEvents()
    {
        $subscriber = new SoftDeleteSubscriber();
        $events = $subscriber->getSubscribedEvents();

        $this->assertEquals(1, count($events));
    }

    public function testOnFlush()
    {
        /**@var OnFlushEventArgs|\PHPUnit_Framework_MockObject_MockObject $eventArgs */
        $eventArgs = $this->createMock(OnFlushEventArgs::class);

        /**@var EntityManagerInterface|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->createMock(EntityManagerInterface::class);
        /**@var UnitOfWork|\PHPUnit_Framework_MockObject_MockObject $unitOfWork */
        $unitOfWork = $this->createMock(UnitOfWork::class);
        /**@var ClassMetadata|\PHPUnit_Framework_MockObject_MockObject $classMetadata */
        $classMetadata = $this->createMock(ClassMetadata::class);

        $subscriber = new SoftDeleteSubscriber();

        $eventArgs->expects($this->once())
            ->method('getEntityManager')
            ->willReturn($entityManager);


        $entityManager->expects($this->once())
            ->method('getUnitOfWork')
            ->willReturn($unitOfWork);

        $unitOfWork->expects($this->once())
            ->method('getScheduledEntityDeletions')
            ->willReturn([new SoftDeletableClass()]);

        $entityManager->expects($this->once())
            ->method('getClassMetadata')
            ->willReturn($classMetadata);

        $unitOfWork->expects($this->once())
            ->method('recomputeSingleEntityChangeSet');

        $subscriber->onFlush($eventArgs);
    }
}