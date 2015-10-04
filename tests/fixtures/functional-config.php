<?php

return [
    'start' => 'route1',
    'routes' => [
        // Route 1
        'route1' => [
            'condition' => [
                'evaluator' => [
                    'cookie' => 'cookieTest'
                ],
                'matcher' => [
                    'notNull' => null
                ]
            ],
            'actions' => [
                'match' => [
                    [
                        'displayFile' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html'
                    ]
                ],
                'doesNotMatch' => [
                    [
                        'goto' => 'route2'
                    ]
                ]
            ]
        ],

        // Route 2
        'route2' => [
            'condition' => [
                'evaluator' => [
                    'queryString' => 'potato'
                ],
                'matcher' => [
                    'inArray' => ['baked', 'boiled', 'grilled']
                ]
            ],
            'actions' => [
                'match' => [
                    [
                        'saveCookie' => [
                            'name' => 'cookieTest',
                            'value' => '{{get.potato}}',
                            'ttl' => '1500',
                            'domain' => '',
                            'path' => '',
                            'secure' => false
                        ]
                    ],
                    [
                        'displayFile' => __DIR__ . '/files/potato-{{get.potato}}.html'
                    ]
                ],
                'doesNotMatch' => [
                    [
                        'goto' => 'default'
                    ]
                ]
            ]
        ],

        // Route 3
        'default' => [
            'condition' => [],
            'actions' => [
                'match' => [
                    [
                        'redirect' => 'http://www.google.com'
                    ]
                ]
            ]
        ]
    ]
];
