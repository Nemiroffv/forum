<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'imagePath' => '@webroot/images',
    'images' => [
     'topic' => [
            'path' => '@webroot/images/topic',
            'webPath' => '@web/images/topic',
            'sizes' => [
                's' => [70, 70],
                'm' => [150, 150],
                'b' => [600, 600]
            ]
       ] ,
        'user' => [
            'path' => '@webroot/images/user',
            'webPath' => '@web/images/user',
            'sizes' => [
                's' => [70, 70],
                'm' => [150, 150],
                'b' => [300, 300]
            ]
        ] ,



    ]
];
