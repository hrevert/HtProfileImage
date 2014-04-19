<?php

namespace HtProfileImage\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\File\MimeType;
use ZfcUser\Entity\UserInterface;

class ProfileImageInputFilter extends ProvidesEventsInputFilter
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
            'required' => true,
            'filters' => array(
                array(
                    'name' => 'File\RenameUpload',
                    'options' => array(
                        'target' => $this->getUploadTarget(),
                        'overwrite' => true,
                    )
                )
            ),
            'validators' => array(
                array(
                    'name' => 'File\MimeType',
                    'options' => array(
                        'mimeType' => array('image/jpeg', 'image/jpg', 'image/png', 'image/gif'),
                        'messages' => array(
                            MimeType::FALSE_TYPE => "Incorrect file type. Only jpeg, jpg, png and gif file types are allowed"
                        )
                    )
                ),
                array(
                    'name' => 'File\UploadFile',
                ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            NotEmpty::IS_EMPTY => 'Please enter a image!'
                        )
                    )
                )
            )
        ));
        $this->getEventManager()->trigger("init", $this);
    }
}
