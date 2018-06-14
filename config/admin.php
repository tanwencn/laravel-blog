<?php

return [

    /*
     * Route configuration.
     */
    'route' => [

        'prefix' => 'admin',

        'namespace' => 'App\\Admin\\Controllers'
    ],

    /*
     * Laravel-admin upload setting.
     */
    'file' => [
        'disk' => 'public',
        'onlyMimes' => ['image'],
        'options' => [
            'uploadOverwrite' => false,
            'tmbURL' => '/.tmb',
            'uploadAllow' => ['image'],
            'uploadOrder'  => ['allow'],
            'uploadMaxSize' => '5M',
            'URL' => '/storage'
        ]
    ]

];
