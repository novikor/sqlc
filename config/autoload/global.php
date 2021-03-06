<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db'              => [
        // A workaround for ZF dev tools
        'driver'         => 'Pdo',
        'dsn'            => 'mysql:dbname=zf3;host=localhost',
        'driver_options' => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'',
        ],

        'adapters' => [
            'mysql'  => [
                'driver' => 'Pdo',
                'dsn'    => 'mysql:dbname=sqlc;host=localhost',
            ],
            'oracle' => [
                'driver'            => 'OCI8',
                'connection_string' => 'localhost/XE',
                'character_set'     => 'AL32UTF8',
            ],
            'sqlite' => [
                'driver'            => 'Pdo',
                'dsn' => 'sqlite:'. BP . '/sql/sqlite/sqlc.db',
            ],
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Db\Adapter\AdapterAbstractServiceFactory',
        ],
    ],
];
