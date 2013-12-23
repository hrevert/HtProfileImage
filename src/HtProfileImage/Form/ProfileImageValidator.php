<?php

namespace HtProfileImage\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\Validator\NotEmpty;
use Zend\Validator\File\MimeType;

class ProfileImageValidator extends ProvidesEventsInputFilter 
{
    public function __construct()
    {

        $this->add(array(
            'name' => 'image',
            'required' => true,
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

