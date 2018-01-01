<?php

namespace SQLC\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;

/**
 * Class Table
 *
 * TODO: extend \Zend\Db\TableGateway\TableGateway
 *
 * @package SQLC\Model
 */
class Table
{
    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @param string                   $table
     *
     * @return string
     */
    public function getRowsCount(Adapter $adapter, string $table)
    {
        $sql = new Sql($adapter);
        $result = $sql->prepareStatementForSqlObject(
            $sql->select()
                ->from($table)
                ->columns(['cnt' => new Expression('COUNT(*)')])
        )->execute();

        $cnt = $result->current()['cnt'];

        return $cnt;
    }

    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @param string                   $table
     *
     * @return string
     */
    public function getTableSize(Adapter $adapter, string $table)
    {
        $result = $adapter->query(
            'SELECT getTableSize(:tableName) AS SIZE_KB FROM dual',
            ['tableName' => $table]
        );

        $size = $result->current()['SIZE_KB'];

        return $size;
    }

}