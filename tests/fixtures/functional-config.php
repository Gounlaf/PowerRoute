<?php

return [
    'start' => 'route1',
    'routes' => [
        // Route 1
        'route1' => [
            'condition' => [
                'evaluator' => [
                    'name' => 'cookie',
                    'argument' => 'cookieTest'
                ],
                'matcher' => [
                    'name' => 'notNull',
                    'argument' => null
                ]
            ],
            'actions' => [
                'match' => [
                    [
                        'action' => 'displayFile',
                        'argument' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html'
                    ]
                ],
                'doesNotMatch' => [
                    [
                        'action' => 'goto',
                        'argument' => 'route2'
                    ]
                ]
            ]
        ],

        // Route 2
        'route2' => [
            'condition' => [
                'evaluator' => [
                    'name' => 'queryString',
                    'argument' => 'potato'
                ],
                'matcher' => [
                    'name' => 'inArray',
                    'argument' => ['baked', 'boiled', 'grilled']
                ]
            ],
            'actions' => [
                'match' => [
                    [
                        'action' => 'saveCookie',
                        'argument' => [
                            'name' => 'cookieTest',
                            'value' => '{{get.potato}}',
                            'ttl' => '1500',
                            'domain' => '',
                            'path' => '',
                            'secure' => false
                        ]
                    ],
                    [
                        'action' => 'displayFile',
                        'argument' => __DIR__ . '/files/potato-{{cookie.cookieTest}}.html'
                    ]
                ],
                'doesNotMatch' => [
                    [
                        'action' => 'goto',
                        'argument' => 'default'
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
                        'action' => 'redirect',
                        'argument' => 'http://www.google.com/'
                    ]
                ],
                'doesNotMatch' => []
            ]
        ]
    ]
];
