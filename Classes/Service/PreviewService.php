<?php

declare(strict_types=1);

namespace SaschaSchieferdecker\YoutubeGdprembed\Service;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class PreviewService
{
    protected array $typoScriptSettings = [];

    public function __construct(
        private readonly ResourceFactory $resourceFactory,
        private readonly ConfigurationManagerInterface $configurationManager,
    ) {}

    public function getTypoScriptSettings(): array
    {
        $this->ensureConfigurationLoaded();
        return $this->typoScriptSettings;
    }

    public function setTypoScriptSettings(array $typoScriptSettings): void
    {
        $this->typoScriptSettings = $typoScriptSettings;
    }

    private function ensureConfigurationLoaded(): void
    {
        if ($this->typoScriptSettings !== []) {
            return;
        }
        $request = $GLOBALS['TYPO3_REQUEST'] ?? null;
        if ($request === null || !ApplicationType::fromRequest($request)->isFrontend()) {
            return;
        }
        $this->typoScriptSettings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
        )['plugin.']['tx_youtubegdprembed.']['settings.'] ?? [];
    }

    /**
     * Fetches, sets and returns metaData about the youtube video
     */
    public function getData(int $contentID, string $youtubeID): array
    {
        $this->ensureConfigurationLoaded();

        $databaseConnection = GeneralUtility::makeInstance(ConnectionPool::class)
            ->getConnectionForTable('tt_content');
        $where = ['uid' => $contentID];

        $metaData = $this->getMeta($youtubeID);
        if ($metaData !== false) {
            if (is_string($metaData->thumbnail_url) && strlen($metaData->thumbnail_url) > 0) {
                $file = $this->savePreviewImage($metaData->thumbnail_url, $youtubeID);
            }

            $data = [
                'youtubegdpr_previewimage' => $file->getUid(),
                'youtubegdpr_width' => $metaData->width,
                'youtubegdpr_height' => $metaData->height,
            ];

            $databaseConnection->update('tt_content', $data, $where);
        } else {
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
            'file' => $file ?? false,
            'width' => $metaData->width ?? 0,
            'height' => $metaData->height ?? 0,
        ];
    }

    private function getMeta(string $youtubeID): mixed
    {
        $url = 'https://www.youtube.com/oembed?url=http%3A//www.youtube.com/watch?v%3D' . preg_replace("/[^a-zA-Z0-9]+/", '', $youtubeID) . '&format=json';

        $result = GeneralUtility::getURL($url);
        if ($result !== false) {
            $json = json_decode($result);
            if (is_object($json)) {
                return $json;
            }
        }
        return false;
    }

    private function savePreviewImage(string $url, string $youtubeID): mixed
    {
        $this->ensureConfigurationLoaded();

        $storage = explode(':', (string)$this->typoScriptSettings['storagePreviewImages'])[0];
        $folder = explode(':', (string)$this->typoScriptSettings['storagePreviewImages'])[1];
        $falstorage = $this->resourceFactory->getStorageObject((int)$storage);
        try {
            $falfolder = $falstorage->getFolder($folder);
        } catch (\Exception $e) {
            if (is_a($e, 'TYPO3\CMS\Core\Resource\Exception\FolderDoesNotExistException')) {
                $falfolder = $falstorage->createFolder($folder);
            }
        }
        $identifier = str_replace('//', '/', $this->typoScriptSettings['storagePreviewImages'] . '/' . $youtubeID . '.jpg');
        try {
            $file = $this->resourceFactory->getFileObjectFromCombinedIdentifier($identifier);
        } catch (\Exception $e) {
            if (is_a($e, 'InvalidArgumentException')) {
                // we prefer the highres image
                $urlHQ = preg_replace("/hqdefault/", 'maxresdefault', $url);
                $previewImage = GeneralUtility::getUrl($urlHQ);
                // load low res image as fallback
                if ($previewImage === false) {
                    $previewImage = GeneralUtility::getUrl($url);
                }
                if ($previewImage !== false) {
                    $tempfile = GeneralUtility::tempnam('yoututegdpr_');
                    GeneralUtility::writeFile($tempfile, $previewImage);
                    $file = $falfolder->addFile($tempfile, $youtubeID . '.jpg');
                    GeneralUtility::unlink_tempfile($tempfile);
                }
            }
        }
        if (is_a($file ?? null, 'TYPO3\CMS\Core\Resource\File')) {
            return $file;
        }
        return false;
    }
}
