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
class IndexController extends AbstractActionController
{
    /**
     * @return \Zend\View\Model\ViewModel
     */
    public function indexAction()
    {
        return new ViewModel([
            'adapters' => SQLC::get()->adapters(),
        ]);
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function generateAction()
    {
        $post = $this->params()->fromPost();
        $table = $post['table'] ?? false;
        $rowsCount = $post['rowsCount'] ?? false;

        try {
            if (!$table || !$rowsCount || $rowsCount <= 0) {
                throw new \Exception('Invalid table or rowsCount received');
            }

            /** @var \SQLC\GenerateData\Model\Api $api */
            $api = SQLC::getServiceLocator()->build(\SQLC\GenerateData\Model\Api::class);
            $data = $api->requestData($table, $rowsCount);

            /** @var \SQLC\GenerateData\Model\MultiImport $importModel */
            $importModel = SQLC::getServiceLocator()->build(\SQLC\GenerateData\Model\MultiImport::class);

            $importModel->importData($table, $data);

            $this->flashMessenger()->addSuccessMessage(sprintf(
                'Successfully generated %s rows for %s',
                $rowsCount, $table
            ));
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        $this->redirect()->toRoute('home');
    }

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function cleanTableAction()
    {
        $post = $this->params()->fromPost();
        $table = $post['table'] ?? false;

        try {
            if (!is_string($table)) {
                throw new \Exception('Invalid table name received');
            }

            /** @var \SQLC\Model\Table $tableModel */
            $tableModel = SQLC::getServiceLocator()->build(\SQLC\Model\Table::class);

            $tableModel->clearTable($table);

            $this->flashMessenger()->addSuccessMessage(sprintf(
                'Successfully cleaned %s (Data & Sequence)',
                $table
            ));
        } catch (\Exception $e) {
            $this->flashMessenger()->addErrorMessage($e->getMessage());
        }

        $this->redirect()->toRoute('home');
    }
}
