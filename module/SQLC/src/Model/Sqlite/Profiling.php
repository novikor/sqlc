<?php

namespace SQLC\Model\Sqlite;

use SQLC\SQLC;
use Zend\Db\TableGateway\TableGateway;

class Profiling
{
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
            'time'       => $time,
            'sql'       => $sql,
        ]);
    }

}