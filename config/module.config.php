<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'HtProfieImage\HtProfieImage' => 'HtProfieImage\Controller\HtProfieImageController'
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
                                'controller' => 'HtProfieImage\HtProfieImage',
                                'action' => 'profile'
                            )
                        )
                    ),
                    'htimagedisplay' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/display-image/:id/[:size/][:gender/]',
                            'defaults' => array(
                                'controller' => 'HtProfieImage\HtProfieImage',
                                'action' => 'display-image'
                            )
                        )
                    ),
                )
            )
        )
    )
);
