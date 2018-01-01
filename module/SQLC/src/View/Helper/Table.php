<?php

namespace SQLC\View\Helper;

use SQLC\SQLC;
use Zend\Db\Adapter\Adapter;
use Zend\View\Helper\AbstractHelper;

class Table extends AbstractHelper
{
    /** @var \SQLC\Model\Table */
    protected $tableModel;

    /**
     * Table constructor.
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __construct()
    {
        $this->tableModel = SQLC::getServiceLocator()->build(\SQLC\Model\Table::class);
    }

    /**
     * @return $this
     */
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
        return $this->tableModel->getRowsCount($adapter, $table);
    }

    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @param string                   $table
     *
     * @return string
     */
    public function getTableSize(Adapter $adapter, string $table)
    {
        return $this->tableModel->getTableSize($adapter, $table);
    }

    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     *
     * @return bool
     */
    public function isOracle(Adapter $adapter)
    {
       return get_class($adapter->getPlatform()) == \Zend\Db\Adapter\Platform\Oracle::class;
    }
}