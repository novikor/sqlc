<?php
/**
 * Created by PhpStorm.
 * User: novikor
 * Date: 31.12.17
 * Time: 18:57
 */

namespace SQLC\GenerateData\Model;

use SQLC\SQLC;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

/**
 * Class MultiImport
 *
 * @package SQLC\GenerateData\Model
 */
class MultiImport
{
    /**
     * @param string $table
     * @param array  $data
     *
     * @throws \Exception
     */
    public function importData(string $table, array $data)
    {
        foreach (SQLC::get()->adapters() as $adapter) {
            $this->import($adapter, $table, $data);
        }
    }

    /**
     * @param \Zend\Db\Adapter\Adapter $adapter
     * @param string                   $table
     * @param array                    $data
     *
     * @throws \Exception
     */
    protected function import(Adapter $adapter, string $table, array $data)
    {
        $connection = $adapter->getDriver()->getConnection();
        if ($adapter->getPlatform()->getName() == 'MySQL') {
            $table = strtolower($table);
        }

        $tableGateway = new TableGateway($table, $adapter);

        $connection->beginTransaction();

        try {

            foreach ($data as $row) {
                $tableGateway->insert($row);
            }

            $connection->commit();

        } catch (\Exception $e) {
            $connection->rollback();
            throw $e;
        }
    }
}