<?php
namespace SaschaSchieferdecker\YoutubeGdprembed\Service;

use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;

class PreviewService implements SingletonInterface
{
    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    private $resourceFactory;
    protected $typoScriptSettings;

    /**
     * @return mixed
     */
    public function getTypoScriptSettings()
    {
        return $this->typoScriptSettings;
    }

    /**
     * @param mixed $typoScriptSettings
     */
    public function setTypoScriptSettings($typoScriptSettings)
    {
        $this->typoScriptSettings = $typoScriptSettings;
    }



    public function __construct()
    {
        $this->loadConfiguration();
        $this->resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
    }

    /**
     * Load setup
     */
    private function loadConfiguration() {
        $objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');
        $configurationManager = $objectManager->get('TYPO3\\CMS\\Extbase\\Configuration\\ConfigurationManagerInterface');
        $this->typoScriptSettings = $configurationManager->getConfiguration(
            \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        )['plugin.']['tx_youtubegdprembed.']['settings.'];
    }

    /**
     * Fetches, sets and returns metaData about the youtube video
     * @param integer $contentID
     * @param string $youtubeID
     * @return array
     */
    public function getData($contentID, $youtubeID) {

        $databaseConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
        $where = ['uid' => (int) $contentID];

        $metaData = $this->getMeta($youtubeID);
        if ($metaData !== false) {
            if (is_string($metaData->thumbnail_url) && strlen($metaData->thumbnail_url) > 0) {
                $file = $this->savePreviewImage($metaData->thumbnail_url, $youtubeID);
            }

            $data = [
                'youtubegdpr_previewimage' => $file->getUid(),
                'youtubegdpr_width' => $metaData->width,
                'youtubegdpr_height' => $metaData->height
            ];

            $databaseConnection->update('tt_content', $data, $where);
        }
        else {
            // try to save image at least
            $url = 'https://img.youtube.com/vi/' . $youtubeID . '/0.jpg';
            $file = $this->savePreviewImage($url, $youtubeID);
            if ($file !== false) {
                $data = [
                    'youtubegdpr_previewimage' => $file->getUid(),
                ];

                $databaseConnection->update('tt_content', $data, $where);
            }
        }

        return [
            'file' => $file,
            'width' => $metaData->width,
            'height' => $metaData->height
        ];
    }

    /**
     * Get Information about video using omembed API
     * @param $youtubeID
     * @return mixed
     */
    private function getMeta($youtubeID) {

        $url = 'https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?v%3D' . preg_replace("/[^a-zA-Z0-9]+/", "", $youtubeID) . '&format=json';


        $result = \TYPO3\CMS\Core\Utility\GeneralUtility::getURL(
            $url
        );
        if ($result !== false) {
            $json = \json_decode($result);
            if (is_object($json)) {
                return $json;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }

    }

    private function savePreviewImage($url, $youtubeID) {
        $storage = explode(':', $this->typoScriptSettings['storagePreviewImages'])[0];
        $folder = explode(':', $this->typoScriptSettings['storagePreviewImages'])[1];
        $falstorage = $this->resourceFactory->getStorageObject((int) $storage);
        try {
            $falfolder = $falstorage->getFolder($folder);
        }
        catch (\Exception $e) {
            if (is_a($e, 'TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException')) {
                $falfolder = $falstorage->createFolder($folder);
            }
        }
        $identifier = str_replace('//', '/', $this->typoScriptSettings['storagePreviewImages'] . '/' . $youtubeID . '.jpg');
        try {
            $file = $this->resourceFactory->getFileObjectFromCombinedIdentifier($identifier);
        }
        catch (\Exception $e) {
            if (is_a($e, 'InvalidArgumentException')) {
                $previewImage = GeneralUtility::getUrl($url);
                if ($previewImage !== false) {
                    $tempfile = GeneralUtility::tempnam('yoututegdpr_');
                    GeneralUtility::writeFile($tempfile, $previewImage);
                    $file = $falfolder->addFile($tempfile, $youtubeID . '.jpg');
                    GeneralUtility::unlink_tempfile($tempfile);
                }
            }
        }
        if (is_a($file, 'TYPO3\CMS\Core\Resource\File')) {
            return $file;
        }
        else {
            return false;
        }



    }
}
