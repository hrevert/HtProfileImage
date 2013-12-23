<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'HtProfileImage\HtProfileImage' => 'HtProfileImage\Controller\HtProfileImageController'
        ),
    ),
    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'child_routes' => array(
                    'htimageupload' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/upload-image',
                            'defaults' => array(
                                'controller' => 'HtProfileImage\HtProfileImage',
                                'action' => 'profile'
                            )
                        )
                    ),
                    'htimagedisplay' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/display-image/:id/[:size/][:gender/]',
                            'defaults' => array(
                                'controller' => 'HtProfileImage\HtProfileImage',
                                'action' => 'display-image'
                            )
                        )
                    ),
                )
            )
        )
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'HtProfileImage' => __DIR__ . '/../view',
        ),
        'template_map' => array(
            'zfc-user/user/index' =>  __DIR__ . '/../view/zfc-user/user/index.phtml'
        )
    ),
);
