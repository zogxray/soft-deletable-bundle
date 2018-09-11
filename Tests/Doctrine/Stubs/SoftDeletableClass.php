<?php
/**
 * Created by PhpStorm.
 * User: zogxray
 * Date: 31.08.18
 * Time: 11:27
 */

namespace Zogxray\SoftDeletableBundle\Tests\Doctrine\Stubs;

use Zogxray\SoftDeletableBundle\Doctrine\Contract\SoftDeletableInterface;
use DateTime;

/**
 * Class SoftDeletableClass
 * @package Zogxray\SoftDeletableBundle\Tests\Doctrine\Stubs
 */
class SoftDeletableClass implements SoftDeletableInterface
{
    /**
     * @var null|DateTime
     */
    private $deletedAt = null;

    /**
     * @param DateTime $deletedAt
     */
    public function setDeletedAt(?DateTime $deletedAt): void
    {
        $this->deletedAt = $deletedAt;
    }

    /**
     * @return DateTime|null
     */
    public function getDeletedAt(): ?DateTime
    {
        return $this->deletedAt;
    }
}