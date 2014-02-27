<?php

namespace HtProfileImage\Form;

use Zend\InputFilter\InputFilter;
use ZfcUser\Entity\UserInterface;

class ProfileImageInputFilter extends InputFilter
{

    protected $uploadDir;

    protected $user;

    public function __construct($uploadDir, UserInterface $user)
    {
        $this->uploadDir = $uploadDir;
        $this->user = $user;
    }

    public function getUploadTarget()
    {
        return $this->uploadDir . '/' . $this->user->getId();
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
