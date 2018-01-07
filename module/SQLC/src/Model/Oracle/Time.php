<?php

namespace SQLC\Model\Oracle;

use SQLC\SQLC;

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

        $this->adapter = SQLC::get()->oracle();
    }

    /**
     * @param string $sqlQuery
     *
     * @return float
     */
    public function execAndGetExecutionTime(string $sqlQuery)
    {
        $result = $this->adapter->query(
            'SELECT execAndGetTime(:sqlQuery) AS TIME FROM dual',
            ['sqlQuery' => $sqlQuery]
        );

        $time = (float)$result->current()['TIME'];

        return $time;
    }
}
