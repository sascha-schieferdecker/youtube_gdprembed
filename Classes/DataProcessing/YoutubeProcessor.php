<?php
namespace SaschaSchieferdecker\YoutubeGdprembed\DataProcessing;

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

use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use SaschaSchieferdecker\YoutubeGdprembed\Service\PreviewService;

/**
 * Class for data processing for the content element "My new content element"
 */
class YoutubeProcessor implements DataProcessorInterface
{
    private $resourceFactory = null;

    /**
     * Process data for the content element "My new content element"
     *
     * @param ContentObjectRenderer $cObj The data of the content element or page
     * @param array $contentObjectConfiguration The configuration of Content Object
     * @param array $processorConfiguration The configuration of this processor
     * @param array $processedData Key/value store of processed data (e.g. to be passed to a Fluid View)
     * @return array the processed data as key/value store
     */
    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    )
    {
        $this->resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);

        //DebuggerUtility::var_dump($processedData['data']['youtubegdpr']);
        $previewService = new PreviewService();

        if ($processedData['data']['youtubegdpr_width'] === 0 && $processedData['data']['youtubegdpr_height'] === 0) {
            $ytdata = $previewService->getData($processedData['data']['uid'], $processedData['data']['youtubegdpr']);
            $processedData['data']['youtubegdpr_width'] = $ytdata['width'];
            $processedData['data']['youtubegdpr_height'] = $ytdata['height'];
            $processedData['data']['youtubegdpr_previewimage'] = $ytdata['file'];
        }
        else {
            // Transform File ID to file Object
            $processedData['data']['youtubegdpr_previewimage'] = $this->resourceFactory->getFileObject($processedData['data']['youtubegdpr_previewimage']);
        }

        // Check if a cookie has to be set on first acceptance of terms
        $config = $previewService->getTypoScriptSettings();
        $processedData['data']['youtubegdpr_persistacceptance'] = (int) $config['persistAcceptance'];
        $processedData['data']['youtubegdpr_privacyPage'] = (int) $config['privacyPage'];

        return $processedData;
    }
}
