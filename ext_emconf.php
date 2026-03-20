<?php
$EM_CONF['youtube_gdprembed'] = [
    'title' => 'Youtube GDPR compliant embed',
    'description' => 'User has to click before any content from youtube is loaded',
    'category' => 'plugin',
    'author' => 'Sascha Schieferdecker',
    'author_email' => 'typo3@sascha-schieferdecker.de',
    'state' => 'stable',
    'version' => '3.0.0',
    'constraints' => [
        'depends' => [
            'typo3' => '13.4.0-13.4.99',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
