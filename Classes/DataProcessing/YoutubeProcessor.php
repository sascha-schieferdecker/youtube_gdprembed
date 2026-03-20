<?php

declare(strict_types=1);

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
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Frontend\ContentObject\DataProcessorInterface;
use SaschaSchieferdecker\YoutubeGdprembed\Service\PreviewService;

class YoutubeProcessor implements DataProcessorInterface
{
    public function __construct(
        private readonly ResourceFactory $resourceFactory,
        private readonly PreviewService $previewService,
    ) {}

    public function process(
        ContentObjectRenderer $cObj,
        array $contentObjectConfiguration,
        array $processorConfiguration,
        array $processedData
    ): array {
        if ($processedData['data']['youtubegdpr_width'] === 0 && $processedData['data']['youtubegdpr_height'] === 0) {
            $ytdata = $this->previewService->getData(
                (int)$processedData['data']['uid'],
                (string)$processedData['data']['youtubegdpr']
            );
            $processedData['data']['youtubegdpr_width'] = $ytdata['width'];
            $processedData['data']['youtubegdpr_height'] = $ytdata['height'];
            $processedData['data']['youtubegdpr_previewimage'] = $ytdata['file'];
        } else {
            try {
                $processedData['data']['youtubegdpr_previewimage'] = $this->resourceFactory->getFileObject(
                    $processedData['data']['youtubegdpr_previewimage']
                );
            } catch (\Exception) {
                $ytdata = $this->previewService->getData(
                    (int)$processedData['data']['uid'],
                    (string)$processedData['data']['youtubegdpr']
                );
                $processedData['data']['youtubegdpr_width'] = $ytdata['width'];
                $processedData['data']['youtubegdpr_height'] = $ytdata['height'];
                $processedData['data']['youtubegdpr_previewimage'] = $ytdata['file'];
            }
        }

        $config = $this->previewService->getTypoScriptSettings();
        $processedData['data']['youtubegdpr_persistacceptance'] = (int)($config['persistAcceptance'] ?? 0);
        $processedData['data']['youtubegdpr_privacyPage'] = (int)($config['privacyPage'] ?? 0);

        return $processedData;
    }
}
