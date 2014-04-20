<?php

namespace HtProfileImage\Controller\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtProfileImage\Controller\ProfileImageController;

class ProfileImageControllerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $controllers)
    {
        $serviceLocator = $controllers->getServiceLocator();
        $service = $serviceLocator->get('HtProfileImage\Service\ProfileImageService');

        return new ProfileImageController($service);
    }
}
