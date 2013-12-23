<?php

namespace HtProfileImage;

use HtProfileImage\Form\GenderForm;

class Module
{
    public function getConfig()
    {
        return include __DIR__."/config/module.config.php";
    }

    public function onBootstrap(MvcEvent $e)
    {
        $app = $e->getApplication();
        $serviceManager = $app->getServiceManager();
        $eventManager = $app->getEventManager();
        $sharedManager = $eventManager->getSharedManager();
        if ($serviceManager->get("HtProfileImage\ModuleOptions")->getEnableGender()) {
            $sharedManager->attach('ZfcUser\Form\Register', 'init', function ($e) use ($sm) {
                $form = $e->getTarget();
                $genderForm = new GenderForm();
                $form->add($genderForm->get('gender'));
            }, 1000);             
        }   
    }


    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HtProfileImage\ModuleOptions' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\ModuleOptions(isset($config['htprofileimage']) ? $config['htprofileimage'] : array());
                },
                'HtProfileImage\StorageModel' => function ($sm) {
                    $storageModel = new Model\StorageModel($sm->get('HtProfileImage\ModuleOptions'));
                }
            )
        );
    }
    ;
    public function getViewHelperConfig()
    {
        return array(
            'htProfileImage' => function ($sm) {
                $htProfileImage = new View\Helper\ProfileImage();
                $serviceLocator = $sm->getLocator();
                $htProfileImage->setUserMapper($serviceLocator->get('zfcuser_user_mapper'));
                $htProfileImage->setDisplayOptions($serviceLocator->get('HtProfileImage\ModuleOptions'));
                $htProfileImage->setStorageModel($serviceLocator->get('HtProfileImage\StorageModel'));
                return $htProfileImage;
            }
        );
    }
}
