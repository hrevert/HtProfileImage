<?php

namespace HtProfileImage\Form;

use HtProfileImage\Entity\User;
use Zend\Form\Form;

class GenderForm extends Form
{
    public function __construct()
    {
        parent::__construct();
        $this->add([
            'name' => 'gender',
            'type' => 'Select',
            'options' => [
                'label' => 'Gender',
                'value_options' => [
                     User::GENDER_MALE => "Male",
                     User::GENDER_FEMALE => "Female",
                ]
            ]
        ]);
    }
}
