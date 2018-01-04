<?php

namespace SQLC\Model;

use Zend\Db\Adapter\Adapter;

/**
 * Class Time
 *
 * @package SQLC\Model
 */
abstract class Time
{
    CONST TYPE_CREATE = 'C';
    CONST TYPE_READ = 'R';
    CONST TYPE_UPDATE = 'U';
    CONST TYPE_DELETE = 'D';

    /** @var Adapter */
    protected $adapter;
    protected $sqlLiteModel;

    /**
     * @param string $sqlQuery
     */
    public function profileQuery(string $sqlQuery)
    {
        //TODO
        $crudType = $this->getQueryCRUDType($sqlQuery);

        $resource = null;

        if ($crudType) {
            $time = $this->execAndGetExecutionTime($sqlQuery, $resource);

//            $this->sqlLiteModel->saveTime(
//                $this->adapter->getPlatform()->getName(),
//                $crudType,
//                $time,
//                $sqlQuery
//            );
        }
    }

    /**
     * @param string $sqlQuery
     * @param $resource
     *
     * @return float
     */
    public abstract function execAndGetExecutionTime(string $sqlQuery, &$resource);

    /**
     * @param string $sqlQuery
     *
     * @return string|false
     */
    protected function getQueryCRUDType(string $sqlQuery)
    {
        //TODO
        return false;
    }
}