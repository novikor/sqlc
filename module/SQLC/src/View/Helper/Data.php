<?php

namespace SQLC\View\Helper;


use Zend\View\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function renderMessages(): string
    {
        /* @var \Zend\View\Helper\FlashMessenger $flash */
        $flash = $this->getView()->flashMessenger();

        $html = '';

        $html .= $flash->render('error', ['alert', 'alert-dismissible', 'alert-danger']);
        $html .= $flash->render('info', ['alert', 'alert-dismissible', 'alert-info']);
        $html .= $flash->render('default', ['alert', 'alert-dismissible', 'alert-warning']);
        $html .= $flash->render('success', ['alert', 'alert-dismissible', 'alert-success']);

        return $html;
    }
}