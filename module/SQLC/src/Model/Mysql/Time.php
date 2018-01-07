<?php

namespace SQLC\Model\Mysql;

use SQLC\SQLC;
use Zend\Db\Adapter\Adapter;

class Time extends \SQLC\Model\Time
{
    /**
     * Time constructor.
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __construct()
    {
        parent::__construct();

        $this->adapter = SQLC::get()->mySql();
    }

    /**
     * @param string $sqlQuery
     *
     * @return float
     */
    public function execAndGetExecutionTime(string $sqlQuery)
    {
        $this->adapter->query('SET PROFILING  = 1;', Adapter::QUERY_MODE_EXECUTE);
        $this->adapter->query($sqlQuery, Adapter::QUERY_MODE_EXECUTE);
        $time = $this->adapter->query(/** @lang MySQL */
            'SELECT ROUND(SUM(DURATION), 3) AS DURATION
                    FROM INFORMATION_SCHEMA.PROFILING
                    WHERE QUERY_ID = 1;', Adapter::QUERY_MODE_EXECUTE)
            ->toArray()[0]['DURATION'];
        $this->adapter->query('SET PROFILING  = 0;', Adapter::QUERY_MODE_EXECUTE);

        return (float)$time;
    }
}
