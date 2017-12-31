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
    public function indexAction()
    {
        $adapters = [
            'MySQL'           => SQLC::get()->mySql(),
            'Oracle Database' => SQLC::get()->oracle(),
        ];

        return new ViewModel([
            'adapters' => $adapters,
        ]);
    }

    public function generateAction()
    {
        $post = $this->params()->fromPost();
        $table = $post['table'] ?? false;
        $rowsCount = $post['rowsCount'] ?? false;

        if(!$table || !$rowsCount || $rowsCount <= 0){
            $this->flashMessenger()->addErrorMessage('Invalid data received');
            $this->redirect()->toRoute('home');
            return;
        }

        $api = new \SQLC\GenerateData\Model\Api();

        $data = $api->requestData($table, $rowsCount);

        var_dump($data);
        die;

        $this->flashMessenger()->addSuccessMessage(sprintf(
            'Successfully generated %s rows for %s',
            $rowsCount, $table
        ));
        $this->redirect()->toRoute('home');
    }
}
