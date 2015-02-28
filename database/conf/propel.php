<?php
return [
    'propel' => [
        'database' => [
            'connections' => [
                'gw2ledger' => [
                    'adapter'    => 'mysql',
                    'settings' => [
                      'charset' => 'utf8',
                      'queries' => [
                        'utf8' => 'SET NAMES utf8 COLLATE utf8_unicode_ci, COLLATION_CONNECTION = utf8_unicode_ci, COLLATION_DATABASE = utf8_unicode_ci, COLLATION_SERVER = utf8_unicode_ci'
                      ]
                    ],
                    'classname'  => 'Propel\Runtime\Connection\ConnectionWrapper',
                    'dsn'        => 'mysql:host=localhost;dbname=gw2ledger',
                    'user'       => 'root',
                    'password'   => '123',
                    'attributes' => []
                ]
            ]
        ],
        'runtime' => [
            'defaultConnection' => 'gw2ledger',
            'connections' => ['gw2ledger']
        ],
        'generator' => [
            'defaultConnection' => 'gw2ledger',
            'connections' => ['gw2ledger']
        ]
    ]
];