<?php

namespace Tienda;

use Laminas\Router\Http\Segment;

return [
/*
    'controllers' => [
        'factories' => [
            Controller\TiendaController::class => InvokableFactory::class,
        ],
    ],
*/
    'router' => [
        'routes' => [
            'tienda' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/tienda[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\TiendaController::class,
                        'action'     => 'index'
                    ],
                ],
            ],
            'bd' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/bd[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]+',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\BdController::class,
                        'action'     => 'index'
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'admin' => __DIR__ . '/../view',
        ],
    ],
    
];