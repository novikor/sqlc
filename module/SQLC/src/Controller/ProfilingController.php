<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SQLC\Controller;

use SQLC\SQLC;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

/**
 * Class IndexController
 *
 * @package SQLC\Controller
 *
 * @method \Zend\Mvc\Plugin\FlashMessenger\FlashMessenger flashMessenger()
 */
class ProfilingController extends AbstractActionController
{
    /**
     * @var mixed|\Zend\Db\Adapter\Adapter
     */
    protected $adapter;
    /**
     * @var \SQLC\Model\Sqlite\Profiling
     */
    protected $sqlLiteModel;

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $this->layout('layout/profiling');

        return new ViewModel([
            'adapters' => SQLC::get()->adapters(),
        ]);

    }

    public function __construct()
    {
        $this->adapter = SQLC::get()->sqlite();
        $this->sqlLiteModel = SQLC::getServiceLocator()->build(\SQLC\Model\Sqlite\Profiling::class);
    }

}
