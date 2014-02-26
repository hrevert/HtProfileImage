<?php

namespace HtProfileImage;

use HtProfileImage\Form\GenderForm;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $serviceManager = $app->getServiceManager();
        $eventManager = $app->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('HtProfileImage\Service\ProfileImageService', 'uploadImage.post', function (EventInterface $e) use ($serviceManager) {
            $cacheManager = $serviceManager->get('HtProfileImage\Service\CacheManager');
            $options = $serviceManager->get('HtProfileImage\ModuleOptions');
            $cacheManager->deleteCache($sharedManager->get('zfcuser_auth_service'), $options->getDisplayFilter());
        }, 10);
    }

    public function getConfig()
    {
        return include __DIR__."/config/module.config.php";
    }

    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'invokables' => [
                'HtProfileImage\ProfileImageForm' => 'HtProfileImage\Form\ProfileImageForm',
            ],
            'factories' => [
                'HtProfileImage\ModuleOptions' => 'HtProfileImage\Factory\ModuleOptionsFactory',
                'HtProfileImage\StorageModel' => 'HtProfileImage\Factory\StorageModelFactory',
                'HtProfileImage\Service\ProfileImageService' => 'HtProfileImage\Factory\ProfileImageServiceFactory',
                'HtProfileImage\StorageResizerProvider' => 'HtProfileImage\Factory\StorageResizerProviderFactory',
                'HtProfileImage\Service\CacheManager' => 'HtProfileImage\Factory\CacheManagerFactory',
            ],
            'aliases' => [
                
            ]
        ];
    }
    

    public function getViewHelperConfig()
    {
        return [
            'factories' => [
                'HtProfileImage\View\Helper\ProfileImage' => 'HtProfileImage\View\Helper\Factory\ProfileImageFactory',            
            ],
            'aliases' => [
                'htProfileImage' => 'HtProfileImage\View\Helper\ProfileImage'
            ]
        ];
    }
}
