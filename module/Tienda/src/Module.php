<?php

namespace Tienda;

use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\Db\Adapter\Adapter;


class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\TiendaController::class => function($container) {
                    return new Controller\TiendaController(
                        $container->get(Model\ProductosTable::class)
                    );
                },
                Controller\BdController::class => function($container) {
                    
                    return new Controller\BdController(new Adapter($container->get('config')['db']));
                },
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\ProductosTable::class => function($container) {
                    $tableGateway = $container->get(Model\ProductosTableGateway::class);
                    return new Model\ProductosTable($tableGateway);
                },
                Model\ProductosTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Productos());
                    return new TableGateway('productos', $dbAdapter, null, $resultSetPrototype);
                },

            ],
        ];
    }



}