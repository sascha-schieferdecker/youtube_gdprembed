<?php
/*\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'Youtube double click video',
        'youtubegdprembed_youtube',
        'EXT:youtube_gdprembed/ext_icon.svg'
    ),
    'CType',
    'youtube_gdprembed'
);*/


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'SaschaSchieferdecker.YoutubeGdprembed',
    'Youtube',
    'LLL:EXT:youtube_gpdrembed/Resources/Private/Language/locallang.xlf:title'
);


$GLOBALS['TCA']['tt_content']['types']['youtubegdprembed_youtube'] = array(
    'showitem' => '
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.general;general,header,subheader,youtubegdpr,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.images,image,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.appearance,overlay,layout,
        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:tabs.access,
        --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xml:palette.visibility;visibility,
');

$temporaryColumns = array (
    'youtubegdpr' => array (
        'exclude' => 1,
        'label' => 'LLL:EXT:youtube_gdprembed/Resources/Private/Language/locallang.xlf:tt_content.youtubegdpr',
        'config' => array (
            'type' => 'text',
            'size' => '60',
            'max'  => '1000'
        )
    ),
    'youtubegdpr_norel' => [
        'exclude' => true,
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
