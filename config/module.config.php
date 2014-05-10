<?php
return [
    'translator' => array(
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),

    'controllers' => [
        'factories' => [
            'HtProfileImage\ProfileImage' => 'HtProfileImage\Controller\Factory\ProfileImageControllerFactory'
        ],
    ],
    'router' => [
        'routes' => [
            'zfcuser' => [
                'child_routes' => [
                    'htimageupload' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/upload-image[/:userId]',
                            'defaults' => [
                                'controller' => 'HtProfileImage\ProfileImage',
                                'action' => 'upload'
                            ]
                        ]
                    ],
                    'htimagedisplay' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/display-image/:id[/]',
                            'defaults' => [
                                'controller' => 'HtProfileImage\ProfileImage',
                                'action' => 'display'
                            ]
                        ]
                    ],
                    'htimagedelete' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/delete-image[/:userId]',
                            'defaults' => [
                                'controller' => 'HtProfileImage\ProfileImage',
                                'action' => 'delete'
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ],
    'view_manager' => [
        'template_path_stack' => [
            'HtProfileImage' => __DIR__ . '/../view',
        ],
        'template_map' => [
            'zfc-user/user/index' =>  __DIR__ . '/../view/zfc-user/user/index.phtml'
        ]
    ],
    'htimg' => [
        'filters' => [
            'htprofileimage_store' => [
                'type' => 'thumbnail',
                'options' => [
                    'width' => 120,
                    'height' => 120,
                    'mode' => 'outbound '
                ]
            ],
            'htprofileimage_display' => [
                'type' => 'thumbnail',
                'options' => [
                    'width' => 100,
                    'height' => 100,
                    'mode' => 'outbound '
                ]
            ],
        ]
    ]
];
