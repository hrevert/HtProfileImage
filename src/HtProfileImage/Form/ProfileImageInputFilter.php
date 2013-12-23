<?php
    
namespace HtProfileImage\Form;

use Zend\InputFilter\InputFilter;
use ZfcUser\Entity\User;

class ProfileImageInputFilter extends InputFilter
{

    protected $uploadDir;

    protected $user;

    public function __construct($uploadDir)
    {
        $this->setUploadDir($uploadDir);
    }

    public function setUploadDir($uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function getUploadDir()
    {
        return $this->uploadDir;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUploadTarget()
    {
        return $this->getUploadDir()."/".$this->getUser()->getId();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function init()
    {
        $this->add(array(
            'name' => 'image',
            'required' => false,
            'filters' => array(
                array(
                    'name' => 'File\RenameUpload',
                    'options' => array(
                        'target' => $this->getUploadTarget(),
                        'overwrite' => true,
                    )
                )            
            )            
        ));
    }
}

