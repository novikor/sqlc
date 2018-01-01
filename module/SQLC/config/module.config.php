<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace SQLC;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router'             => [
        'routes' => [
            'home'     => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'generate' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/generate[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'generate',
                    ],
                ],
            ],
            'cleanTable' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/cleanTable[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'cleanTable',
                    ],
                ],
            ],
            'refreshStatistics' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/refreshStatistics[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'refreshStatistics',
                    ],
                ],
            ],
            'refreshFullText' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/refreshFullText[/]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'refreshFullText',
                    ],
                ],
            ],
        ],
    ],
    'controllers'        => [
        'factories'  => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
        'invokables' => [
            'SQLC/Controller/SQLC' => Controller\IndexController::class,
        ],
    ],
    'view_helpers'       => [
        'invokables' => [
            'tableHelper' => View\Helper\Table::class,
            'helper' => View\Helper\Data::class,
        ],
    ],
    'view_manager'       => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map'             => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'sqlc/index/index'        => __DIR__ . '/../view/sqlc/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'sqlc/index/tableColumns' => __DIR__ . '/../view/sqlc/index/tableColumns.phtml',
            'sqlc/index/tableData'    => __DIR__ . '/../view/sqlc/index/tableData.phtml',
        ],
        'template_path_stack'      => [
            __DIR__ . '/../view',
        ],
    ],
    'view_helper_config' => [
        'flashmessenger' => [
            'message_open_format'      => '<div%s><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><ul><li>',
            'message_close_string'     => '</li></ul></div>',
            'message_separator_string' => '</li><li>',
        ],
    ],
];
