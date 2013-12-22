<?php

namespace HtProfileImage\Model;

use ZfcUser\Mapper\UserMapper;
use HtProfileImage\Options\ModuleOptions;

class ProfileImageViewer
{
    protected $userMapper;

    protected $retrievedUsers = array();

    protected $moduleOptions;

    public function setUserMapper(UserMapper $userMapper)
    {
        $this->userMapper = $userMapper;
    }

    public function getUserMapper()
    {
        return $this->userMapper;
    }

    public function setModuleOptions(ModuleOptions $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;
    }

    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    protected function getUser($id)
    {
        if (!isset($this->retrievedUsers[$id])) {
            $user = $this->getUserMapper()->findById($id);
            $this->retrievedUsers[$id] = $user;
        }
        return array(
            'name' => $this->retrievedUsers[$id]->getDisplayName(),
            'gender' => $this->retrievedUsers[$id]->getGender(),  
            'email' => $this->retrievedUsers[$id]->getEmail(),            
        );
    }

    public function getImageUrl($basePath, $id, $gender = null, $email = null)
    {
        
    }
}
