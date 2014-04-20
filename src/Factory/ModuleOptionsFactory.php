<?php

namespace HtProfileImage\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use HtProfileImage\Options\ModuleOptions;

class ModuleOptionsFactory implements FactoryInterface
{
    /**
     *
     * @param  ServiceLocatorInterface $serviceLocator
     * @return ModuleOptions
     */
    public function createService(ServiceLocatorInterface $sm)
    {
        $config = $sm->get('Config');

        return new ModuleOptions(isset($config['htprofileimage']) ? $config['htprofileimage'] : []);
    }
}
