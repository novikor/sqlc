<?php

namespace SQLC;

use Zend\ServiceManager\Factory\InvokableFactory;

return [
    Model\Table::class => InvokableFactory::class,
    GenerateData\Model\Api::class => InvokableFactory::class,
    GenerateData\Model\MultiImport::class => InvokableFactory::class,
];