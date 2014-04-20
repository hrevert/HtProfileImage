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

    protected $maxImageFileSize;

    public function __construct($uploadDir, UserInterface $user, $maxImageFileSize)
    {
        $this->uploadDir = $uploadDir;
        $this->user = $user;
        $this->maxImageFileSize = $maxImageFileSize;
    }

    public function getUploadTarget()
    {
        return $this->uploadDir . '/' . $this->user->getId();
    }

    public function init()
    {
        $this->add([
            'name' => 'image',
            'required' => true,
            'filters' => [
                [
                    'name' => 'File\RenameUpload',
                    'options' => [
                        'target' => $this->getUploadTarget(),
                        'overwrite' => true,
                    ]
                ]
            ],
            'validators' => [
                [
                    'name' => 'File\MimeType',
                    'options' => [
                        'mimeType' => ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'],
                        'messages' => [
                            MimeType::FALSE_TYPE => "Incorrect file type. Only jpeg, jpg, png and gif file types are allowed"
                        ]
                    ]
                ],
                [
                    'name' => 'File\UploadFile',
                ],
                [
                    'name'      => 'File\Size',
                    'options'   => [
                        'max' => $this->maxImageFileSize,
                    ]
                ],
                [
                    'name' => 'NotEmpty',
                    'options' => [
                        'messages' => [
                            NotEmpty::IS_EMPTY => 'Please enter a image!'
                        ]
                    ]
                ]
            ]
        ]);
        $this->getEventManager()->trigger("init", $this);
    }
}
