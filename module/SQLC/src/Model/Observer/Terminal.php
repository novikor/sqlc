<?php
/**
 * Created by PhpStorm.
 * User: novikor
 * Date: 17.06.18
 * Time: 17:19
 */

namespace SQLC\Model\Observer;

class Terminal
{
    const EVENT = 'terminal_query_execute_before';

    /**
     * @param array $params
     */
    public function execute(array $params)
    {
        list($platform, $sql) = $params;

        /** @var \SQLC\Model\TimeFactory  $timeModelFactory */
        $timeModelFactory= \SQLC\SQLC::getServiceLocator()->get(\SQLC\Model\TimeFactory::class);

        $timeModelFactory->create(ucfirst($platform))->profileQuery($sql);
    }
}