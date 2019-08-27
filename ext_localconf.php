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

// Register hook to show preview of tt_content element of CType="youtubegdprembed_youtube" in page module
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['cms/layout/class.tx_cms_layout.php']['tt_content_drawItem']['youtubegdprembed_youtube'] =
    \SaschaSchieferdecker\YoutubeGdprembed\Hooks\PageLayoutView\YoutubePreviewRenderer::class;

// Register hook to check if a new image has to be pulled after changind a video ID
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processDatamapClass']['youtube_gdprembed'] = 'SaschaSchieferdecker\\YoutubeGdprembed\\Hooks\\TceMain\\TceMainHook';
$GLOBALS ['TYPO3_CONF_VARS']['SC_OPTIONS']['t3lib/class.t3lib_tcemain.php']['processCmdmapClass']['youtube_gdprembed'] = 'SaschaSchieferdecker\\YoutubeGdprembed\\Hooks\\TceMain\\TceMainHook';
