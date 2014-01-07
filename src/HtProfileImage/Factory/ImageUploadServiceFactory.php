<?php
namespace HtProfileImage\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\Service\ImageUpload;

class ImageUploadServiceFactory implements FactoryInterface
{
    /**
     * gets ImageUpload Service 
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @return ImageUpload
     */    
     public function createService(ServiceLocatorInterface $sm)
     {
        $service = new ImageUpload();
        $service->setServiceLocator($sm);
        return $service;         
     }
}
