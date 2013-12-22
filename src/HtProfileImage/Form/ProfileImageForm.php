<?php

namespace HtProfileImage\Form;

use Zend\Form\Form;
use ZfcBase\Form\ProfileImageValidator;

class ProfileImageForm extends ProvidesEventsForm
{
    public function __construct()
    {
        parent::__construct('profile_image_upload');
        $this->setAttribute('class', 'image_upload_form');
        $this->setAttribute('enctype', 'multipart/form-data');
        $this->add(array(
            'name' => 'image',
            'type' => 'File',
        ));

        $this->add(array(
            'name' => 'submit',
            'type'  => 'Submit',
            'attributes' => array(
                'value' => 'Upload',
                'class' => 'btn btn-lg btn-success'
            ),
        ));

        $this->getEventManager()->trigger('init', $this);
    }


} 
