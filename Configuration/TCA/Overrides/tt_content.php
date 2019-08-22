<?php
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'Youtube',
        'youtubegdprembed_youtube',
        ''
    ),
    'CType',
    'youtube_gdprembed'
);

$GLOBALS['TCA']['tt_content']['types']['youtubegdprembed_youtube'] = array(
    'showitem' => '
       --div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:general,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.general;general,youtubegdpr,youtubegdpr_norel,--div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.frames;frames,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.appearanceLinks;appearanceLinks,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:language,--palette--;;language,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:access,--palette--;;hidden,--palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access;access,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:categories,--div--;LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:sys_category.tabs.category,categories,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:notes,rowDescription,--div--;LLL:EXT:core/Resources/Private/Language/Form/locallang_tabs.xlf:extended
    ');

$temporaryColumns = array (
    'youtubegdpr' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:youtube_gdprembed/Resources/Private/Language/locallang.xlf:tt_content.youtubegdpr',
        'config' => array (
            'type' => 'input',
            'size' => '60',
            'max'  => '255'
        )
    ),
    'youtubegdpr_norel' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:youtube_gdprembed/Resources/Private/Language/locallang.xlf:tt_content.youtubegdpr_norel',
        'config' => [
            'type' => 'check',
            'items' => [
                '1' => [
                    '0' => 'LLL:EXT:lang/Resources/Private/Language/locallang_core.xlf:labels.enabled'
                ]
            ],
        ],
    ],
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);
