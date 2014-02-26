<?php

return array(
    'controllers' => array(
        'factories' => array(
            'HtProfileImage\ProfileImage' => 'HtProfileImage\Controller\Factory\ProfileImageControllerFactory'
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
                                'controller' => 'HtProfileImage\ProfileImage',
                                'action' => 'upload'
                            )
                        )
                    ),
                    'htimagedisplay' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/display-image/:id/[:size/][:gender/]',
                            'defaults' => array(
                                'controller' => 'HtProfileImage\ProfileImage',
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
    'htimg' => [
        'filters' => [
            'htprofileimage_store' => [  // # Transforms 50x40 to 32x32, while cropping the width
                'type' => 'thumbnail',
                'options' => [
                    'width' => 120,
                    'height' => 120,
                    'mode' => 'outbound '
                ]
            ],        
        ]   
    ]
);
