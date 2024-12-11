<?php
$EM_CONF['youtube_gdprembed'] = array(
    'title' => 'Youtube GDPR compliant embed',
    'description' => 'User has to click before any content from youtube is loaded',
    'category' => 'plugin',
    'author' => 'Sascha Schieferdecker',
    'author_email' => 'typo3@sascha-schieferdecker.de',
    'state' => 'beta',
    'version' => '2.0.1',
    'constraints' => array(
        'depends' =>
            [
                'typo3' => '11.5.0-12.4.99',
            ],
        'conflicts' => [

        ],
        'suggests' => [

        ],
    ),
);

