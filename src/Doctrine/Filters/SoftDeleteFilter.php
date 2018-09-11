<?php
/**
 * Created by PhpStorm.
 * User: Zogxray (Viktor Pavlov)
 * Date: 31.08.18
 * Time: 11:04
 */

namespace Zogxray\SoftDeletableBundle\Doctrine\Filters;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;
use Zogxray\SoftDeletableBundle\Doctrine\Contract\SoftDeletableInterface;

/**
 * Class SoftDeleteFilter
 * @package Zogxray\SoftDeletableBundle\Doctrine\Filters
 */
class SoftDeleteFilter extends SQLFilter
{
    /**
     * @param ClassMetadata $targetEntity
     * @param string $targetTableAlias
     * @return string|void
     */
    public function addFilterConstraint(ClassMetadata $targetEntity, $targetTableAlias)
    {
        if (false === $targetEntity->getReflectionClass()->implementsInterface(SoftDeletableInterface::class)) {
            return '';
        }

        if (!$targetEntity->hasField('deletedAt')) {
            return '';
        }

        $column = $targetEntity->getColumnName('deletedAt');

        return sprintf('%s.%s IS NULL', $targetTableAlias, $column);
    }
}
