<?php
/**
 * Created by PhpStorm.
 * User: Zogxray (Viktor Pavlov)
 * Date: 31.08.18
 * Time: 10:58
 */

namespace Zogxray\SoftDeletableBundle\Doctrine\Contract;

use DateTime;

/**
 * Interface SoftDeletableInterface
 * @package Zogxray\SoftDeletableBundle\Doctrine\Contract
 */
interface SoftDeletableInterface
{
    /**
     * @param DateTime $deletedAt
     */
    public function setDeletedAt(?DateTime $deletedAt) :void;

    /**
     * @return DateTime
     */
    public function getDeletedAt() :?DateTime;
}
