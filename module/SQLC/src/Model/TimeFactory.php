<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: novikor
 * Date: 17.06.18
 * TimeFactory: 15:06
 */

namespace SQLC\Model;

use SQLC\Model\Time as TimeAbstract;
use SQLC\SQLC;

class TimeFactory
{
    /**
     * @param string $platform
     *
     * @return \SQLC\Model\Time
     */
    public function create(string $platform): TimeAbstract
    {
        $newModelName = "SQLC\\Model\\$platform\\Time";

        return SQLC::getServiceLocator()->build($newModelName);
    }
}