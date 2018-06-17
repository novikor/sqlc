<?php

namespace SQLC;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    Model\Table::class                    => InvokableFactory::class,
    GenerateData\Model\Api::class         => InvokableFactory::class,
    GenerateData\Model\MultiImport::class => InvokableFactory::class,
    Model\Sqlite\Profiling::class         => InvokableFactory::class,
    Model\Mysql\Time::class               => InvokableFactory::class,
    Model\Oracle\Time::class              => InvokableFactory::class,
    Model\TimeFactory::class              => InvokableFactory::class,
    EventManager::class                   => InvokableFactory::class,
];