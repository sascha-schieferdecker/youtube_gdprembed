<?php
if (!defined('TYPO3_MODE')) {
    die ('Access denied.');
}
$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
$iconRegistry->registerIcon(
    'tx-youtube-gdprembed-video',
    \TYPO3\CMS\Core\Imaging\IconProvider\BitmapIconProvider::class,
    ['source' => 'EXT:youtube_gdprembed/ext_icon.svg']
);

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:youtube_gdprembed/Configuration/TSconfig/ContentElementWizard.txt">');
