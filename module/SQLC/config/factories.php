<?php

namespace SQLC;

use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\ServiceManager\ServiceManager;

return [
    Model\Table::class                    => InvokableFactory::class,
    GenerateData\Model\Api::class         => InvokableFactory::class,
    GenerateData\Model\MultiImport::class => InvokableFactory::class,
    Model\Sqlite\Profiling::class         => InvokableFactory::class,
    Model\Mysql\Time::class               => InvokableFactory::class,
    Model\Oracle\Time::class              => InvokableFactory::class,
    \SQLC\Model\Time::class               => function (ServiceManager $sm, $className, array $options) {
        $dbType = ucfirst($options['type']);

        $newModelName = "SQLC\\Model\\$dbType\\Time";

        try {
            return $sm->build($newModelName);
        } catch (ServiceNotFoundException $e) {
            return false;
        }
    },
];