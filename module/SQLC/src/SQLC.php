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
     * SQLC constructor.
     */
    private function __construct()
    {
        try {
            $this->mysqlAdapter = self::getServiceLocator()->get('mysql');
            $this->oracleAdapter = self::getServiceLocator()->get('oracle');

            $this->adapters = [
                'MySQL'           => $this->mysqlAdapter,
                'Oracle Database' => $this->oracleAdapter,
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
     * @param MvcEvent $mvcEvent
     */
    public static function init(MvcEvent $mvcEvent)
    {
        static::$serviceLocator = $mvcEvent->getApplication()->getServiceManager();
        self::$instance = new self();
    }

    /**
     * @return \SQLC\SQLC
     */
    public static function get()
    {
        return self::$instance;
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