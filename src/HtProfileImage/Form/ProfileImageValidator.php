<?php

namespace HtProfileImage\Form;

use ZfcBase\InputFilter\ProvidesEventsInputFilter;
use Zend\Validator\NotEmpty;

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
                        'mimeType' => array('image/jpeg', 'image/jpg', 'image/png', 'image/gif')
                    )
                ),
                array(
                    'name' => 'File\FilesSize',
                    'options' => array(
                        'max' => '25MB'
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

