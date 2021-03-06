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
     * ProfilingController constructor.
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __construct()
    {
        $this->adapter = SQLC::get()->sqlite();
        $this->sqlLiteModel = SQLC::getServiceLocator()->build(\SQLC\Model\Sqlite\Profiling::class);
    }

    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        $this->layout('layout/profiling');

        $avgTime = $this->sqlLiteModel->getAvgTime() ?: [null, null, null, null];
        $lastQueryTime = $this->sqlLiteModel->getLastQueryTime();
        $queries = [
            'MySQL'  => $this->sqlLiteModel->getQueries('MySQL'),
            'Oracle' => $this->sqlLiteModel->getQueries('Oracle'),
        ];

        list($selectAvgTime, $insertAvgTime, $updateAvgTime, $deleteAvgTime) = $avgTime;

        return new ViewModel([
            'adapters'      => SQLC::get()->adapters(),
            'selectAvgTime' => $selectAvgTime,
            'insertAvgTime' => $insertAvgTime,
            'updateAvgTime' => $updateAvgTime,
            'deleteAvgTime' => $deleteAvgTime,
            'lastQueryTime' => $lastQueryTime,
            'queries'       => $queries,
        ]);
    }

    public function resetAction()
    {
        try {
            $this->sqlLiteModel->truncate();

            $this->flashMessenger()->addSuccessMessage('Successfully truncated profiling table');
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        $this->redirect()->toRoute('profiling');
    }

}
