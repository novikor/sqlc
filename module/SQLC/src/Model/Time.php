<?php

namespace SQLC\Model;

use SQLC\SQLC;
use Zend\Db\Adapter\Adapter;

/**
 * Class Time
 *
 * @package SQLC\Model
 */
abstract class Time
{
    CONST TYPE_CREATE = 'CREATE';
    CONST TYPE_READ = 'SELECT';
    CONST TYPE_UPDATE = 'UPDATE';
    CONST TYPE_DELETE = 'DELETE';

    /** @var Adapter */
    protected $adapter;
    /** @var Sqlite\Profiling */
    protected $sqlLiteModel;

    /**
     * @param string $sqlQuery
     */
    public function profileQuery(string $sqlQuery)
    {
        $crudType = $this->getQueryCRUDType($sqlQuery);

        if ($crudType) {
            $time = $this->execAndGetExecutionTime($sqlQuery);

            $this->sqlLiteModel->saveTime(
                $this->adapter->getPlatform()->getName(),
                $crudType,
                $time,
                $sqlQuery
            );
        }
    }

    /**
     * Time constructor.
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __construct()
    {
        $this->sqlLiteModel = SQLC::getServiceLocator()
            ->build(\SQLC\Model\Sqlite\Profiling::class);
    }


    /**
     * @param string $sqlQuery
     *
     * @return float
     */
    public abstract function execAndGetExecutionTime(string $sqlQuery);

    /**
     * @param string $sqlQuery
     *
     * @return string|false
     */
    protected function getQueryCRUDType(string $sqlQuery)
    {
        $firstWord = strtoupper(trim(strtok($sqlQuery, ' ')));

        $crudTypes = [
            static::TYPE_CREATE,
            static::TYPE_READ,
            static::TYPE_UPDATE,
            static::TYPE_DELETE,
        ];

        if (in_array($firstWord, $crudTypes)) {
            return $firstWord;
        } else {
            return false;
        }
    }
}