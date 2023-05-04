<?php
$EM_CONF['youtube_gdprembed'] = array(
    'title' => 'Youtube GDPR compliant embed',
    'description' => 'User has to click before any content from youtube is loaded',
    'category' => 'plugin',
    'author' => 'Sascha Schieferdecker',
    'author_email' => 'typo3@sascha-schieferdecker.de',
    'state' => 'beta',
    'internal' => '',
    'uploadfolder' => '0',
    'createDirs' => '',
    'clearCacheOnLoad' => 1,
    'version' => '2.0.0',
    'constraints' => array(
        'depends' =>
            [
                'typo3' => '9.5.00-11.5.99',
            ],
        'conflicts' => [

        ],
        'suggests' => [

        ],
    ),
);

