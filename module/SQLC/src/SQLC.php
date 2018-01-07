<?php

namespace SQLC;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class SQLC
 *
 * @package SQLC
 *
 */
class SQLC
{
    const SQLITE_INSTALL_SCRIPT = BP . '/sql/sqlite/install.sql';
    /**
     * @var ServiceLocatorInterface
     */
    protected static $serviceLocator;
    /**
     * @var
     */
    protected static $instance;
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $oracleAdapter;
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $mysqlAdapter;

    /** @var \Zend\Db\Adapter\Adapter[] */
    protected $adapters;
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $sqliteAdapter;

    /**
     * SQLC constructor.
     */
    private function __construct()
    {
        try {
            $this->mysqlAdapter = self::getServiceLocator()->get('mysql');
            $this->oracleAdapter = self::getServiceLocator()->get('oracle');
            $this->sqliteAdapter = self::getServiceLocator()->get('sqlite');
            $this->installSqliteDatabase();

            $this->adapters = [
                'MySQL'     => $this->mysqlAdapter,
                'Oracle XE' => $this->oracleAdapter,
            ];

        } catch (NotFoundExceptionInterface $e) {
            echo $e;
        } catch (ContainerExceptionInterface $e) {
            echo $e;
        }
    }

    /**
     * @return ServiceLocatorInterface
     */
    public static function getServiceLocator()
    {
        return static::$serviceLocator;
    }

    /**
     * @throws \Exception
     */
    protected function installSqliteDatabase()
    {
        $installSql = file_get_contents(static::SQLITE_INSTALL_SCRIPT);
        if (!$installSql) {
            throw new \Exception('Can`t read file: ' . static::SQLITE_INSTALL_SCRIPT);
        }
        $pdo = $this->sqliteAdapter->getDriver()->getConnection()->getResource();
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION);
        $pdo->exec($installSql);
    }

    public function sqlite()
    {
        return $this->sqliteAdapter;
    }

    /**
     * @return \SQLC\SQLC
     */
    public static function get()
    {
        return self::$instance;
    }

    /**
     * @param MvcEvent $mvcEvent
     */
    public static function init(MvcEvent $mvcEvent)
    {
        static::$serviceLocator = $mvcEvent->getApplication()->getServiceManager();
        self::$instance = new self();
    }

    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function mySql()
    {
        return $this->mysqlAdapter;
    }

    /**
     * @return \Zend\Db\Adapter\Adapter
     */
    public function oracle()
    {
        return $this->oracleAdapter;
    }

    /**
     * @return array|\Zend\Db\Adapter\Adapter[]
     */
    public function adapters()
    {
        return $this->adapters;
    }
}