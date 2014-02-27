<?php

namespace HtProfileImage\Form;

use HtProfileImage\Entity\User;
use Zend\Form\Form;

class GenderForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->add(array(
            'name' => 'gender',
            'type' => 'Select',
            'options' => array(
                'label' => 'Gender',
                'value_options' => array(
                     User::GENDER_MALE => "Male",
                     User::GENDER_FEMALE => "Female",
                )
            )
        ));
    }
}
