<?php

namespace SQLC\View\Helper;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Sql;
use Zend\View\Helper\AbstractHelper;

class Table extends AbstractHelper
{
    public function __invoke()
    {
        return $this;
    }

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

        return $result->current()['cnt'];
    }
}