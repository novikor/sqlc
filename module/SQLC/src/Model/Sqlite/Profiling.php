<?php

namespace SQLC\Model\Sqlite;

use SQLC\SQLC;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class Profiling
{
    const DBMS_ORACLE = 'Oracle';
    const DBMS_MYSQL = 'MySQL';

    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $adapter;
    /**
     * @var \Zend\Db\TableGateway\TableGateway
     */
    protected $tableGateway;

    public function __construct()
    {
        $this->adapter = SQLC::get()->sqlite();
        $this->tableGateway = new TableGateway('profiling', $this->adapter);
    }

    public function getSelect()
    {
        return $this->tableGateway->select();
    }

    /**
     * @param string $dbms
     * @param string $crud_type
     * @param float  $time
     * @param string $sql
     */
    public function saveTime(
        string $dbms,
        string $crud_type,
        float $time,
        string $sql
    )
    {
        $this->tableGateway->insert([
            'dbms'      => $dbms,
            'crud_type' => $crud_type,
            'time'      => $time,
            'sql'       => $sql,
            'microtime' => microtime(true),
        ]);
    }

    public function getAvgTime(): array
    {

        $avgTime = [];
        $query = $this->adapter->query("
        SELECT
          dbms,
          crud_type,
          ROUND(AVG(time), 6) AS time
        FROM profiling
        GROUP BY dbms, crud_type
        ", Adapter::QUERY_MODE_EXECUTE
        )->toArray();

        foreach ($query as $row) {
            $avgTime[$row['crud_type']][$row['dbms']] = $row['time'];
        }

        $avgTime += array_values($avgTime);

        return $avgTime;
    }

}