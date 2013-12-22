<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'HtProfieImage\ImageUpload' => 'HtProfieImage\Controller\ImageUploadController'
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
                                'controller' => 'HtProfieImage\ImageUpload',
                                'action' => 'profile'
                            )
                        )
                    )
                )
            )
        )
    )
);
