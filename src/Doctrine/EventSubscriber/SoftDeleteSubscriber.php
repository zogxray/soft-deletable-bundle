<?php
/**
 * Created by PhpStorm.
 * User: Zogxray (Viktor Pavlov)
 * Date: 31.08.18
 * Time: 11:01
 */

namespace Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\UnitOfWork;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Zogxray\SoftDeletableBundle\Doctrine\Contract\SoftDeletableInterface;

/**
 * Class SoftDeleteSubscriber
 * @package Zogxray\SoftDeletableBundle\Doctrine\EventSubscriber
 */
class SoftDeleteSubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush,
        ];
    }

    /**
     * If it's a SoftDelete object, update the "deletedAt" field
     * and skip the removal of the object
     *
     * @param OnFlushEventArgs $eventArgs
     * @return void
     * @throws ORMException
     */
    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        /** @var EntityManager $entityManager */
        $entityManager = $eventArgs->getEntityManager();
        /** @var UnitOfWork $unitOfWork */
        $unitOfWork = $entityManager->getUnitOfWork();

        foreach ($unitOfWork->getScheduledEntityDeletions() as $entity) {
            if ($entity instanceof SoftDeletableInterface) {

                $deletedAt = $entity->getDeletedAt() ?? new \DateTime('now');

                $entity->setDeletedAt($deletedAt);

                $entityManager->persist($entity);

                /** @var ClassMetadata $meta */
                $meta = $entityManager->getClassMetadata(get_class($entity));
                $unitOfWork->recomputeSingleEntityChangeSet($meta, $entity);
            }
        }
    }
}
