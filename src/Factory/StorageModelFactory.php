<?php
namespace HtProfileImage\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\Model\StorageModel;

class StorageModelFactory implements FactoryInterface
{
    /**
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return StorageModel
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        return new StorageModel($sm->get('HtProfileImage\ModuleOptions'));
    }
}
