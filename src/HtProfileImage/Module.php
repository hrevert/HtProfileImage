<?php

namespace HtProfileImage;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

class Module implements 
    AutoloaderProviderInterface,
    BootstrapListenerInterface,
    ConfigProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function onBootstrap(EventInterface $e)
    {
        $app = $e->getApplication();
        $serviceManager = $app->getServiceManager();
        $eventManager = $app->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        $sharedManager->attach('HtProfileImage\Service\ProfileImageService ', 'uploadImage.post', function (EventInterface $e) use ($serviceManager) {
            $cacheManager = $serviceManager->get('HtProfileImage\Service\CacheManager');
            $options = $serviceManager->get('HtProfileImage\ModuleOptions');
            $cacheManager->deleteCache($sharedManager->get('zfcuser_auth_service'), $options->getDisplayFilter());
        }, 10000);
    }

    /**
     * {@inheritDoc}
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * {@inheritDoc}
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\ClassMapAutoloader' => [
                __DIR__ . '/../../autoload_classmap.php',
            ],
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/../src/',
                ],
            ],
        ];
    }

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
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
