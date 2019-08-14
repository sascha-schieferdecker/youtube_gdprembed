<?php
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPlugin(
    array(
        'Youtube double click video',
        'youtubegdprembed_youtube',
        ''
    ),
    'CType',
    'youtube_gdprembed'
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
        'label' => 'LLL:EXT:youtube_gdprembed/Resources/Private/Language/locallang_db.xlf:tt_content.youtubegdpr',
        'config' => array (
            'type' => 'text',
            'size' => '60',
            'max'  => '1000'
        )
    )
);

TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns(
    'tt_content',
    $temporaryColumns
);
