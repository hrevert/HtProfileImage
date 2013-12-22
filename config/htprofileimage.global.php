<?php

$settings = array();

return array(
    'htprofileimage' => $settings,
    'zfcuser' => array(
        'user_entity_class' => (isset($settings['enable_gender']) && $settings['enable_gender'] == true) ? "HtProfileImage\Entity\User" : "ZfcUser\Entity\User",
    )
);
