<?php

namespace SQLC;

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
    /**
     *
     */
    const SQLITE_INSTALL_SCRIPT = BP . '/sql/sqlite/install.sql';
    /**
     * @var ServiceLocatorInterface
     */
    protected static $serviceLocator;
    /**
     * @var \SQLC\SQLC
     */
    protected static $instance;
    /**
     * @var \SQLC\EventManager
     */
    protected static $eventManager;
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

        } catch (\Exception $e) {
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

    /**
     * @return \SQLC\EventManager
     */
    public static function getEventManager(): EventManager
    {
        return static::$eventManager;
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
        static::$eventManager = static::$serviceLocator->get(EventManager::class);
        self::$instance = new self();

        static::initObservers();
    }


    /**
     * Initialize observers
     * @see ../config/observers.php
     */
    protected static function initObservers()
    {
        $observersList = require __DIR__ . '/../config/observers.php';

        foreach ($observersList as $event => $observer) {
            static::$eventManager->attachObserver($observer, $event);
        }
    }

    /**
     * @return mixed|\Zend\Db\Adapter\Adapter
     */
    public function sqlite()
    {
        return $this->sqliteAdapter;
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