<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Mvc\MvcEvent;
use Application\View\Helper\MiniHelper;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements ViewHelperProviderInterface
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getViewHelperConfig()
    {
        return [

            'aliases' => [

            ],

            'factories' => [


            ],

        ];
    }

    public function onBootstrap(MvcEvent $event)
    {
        $application = $event->getApplication();
        
        $serviceManager = $application->getServiceManager();
        
        $viewModel = $event->getViewModel();
        
        $globalConfig = $serviceManager->get("Config");

    }
}
