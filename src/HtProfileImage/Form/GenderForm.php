<?php

namespace HtProfileImage\Form;

use HCommons\Model\GenderManager;

class GenderForm
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'gender',
            'type' => 'Select',
            'options' => array(
                'label' => 'Gender',
                'value_options' => array(
                     GenderManager::GENDER_MALE => "Male",
                     GenderManager::GENDER_FEMALE => "Female",
                )
            )
        ));        
    }
}
