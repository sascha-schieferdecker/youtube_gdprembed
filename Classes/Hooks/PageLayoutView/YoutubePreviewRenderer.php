<?php
namespace SaschaSchieferdecker\YoutubeGdprembed\Hooks\PageLayoutView;

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

use \TYPO3\CMS\Backend\View\PageLayoutViewDrawItemHookInterface;
use \TYPO3\CMS\Backend\View\PageLayoutView;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class YoutubePreviewRenderer implements PageLayoutViewDrawItemHookInterface
{

    /**
     * Preprocesses the preview rendering of a content element.
     *
     * @param \TYPO3\CMS\Backend\View\PageLayoutView $parentObject Calling parent object
     * @param bool $drawItem Whether to draw the item using the default functionalities
     * @param string $headerContent Header content
     * @param string $itemContent Item content
     * @param array $row Record row of tt_content
     *
     * @return void
     */
    public function preProcess(PageLayoutView &$parentObject, &$drawItem, &$headerContent, &$itemContent, array &$row)
    {
        {
            if ($row['CType'] === 'youtubegdprembed_youtube') {
                $itemContent .= '<b>Video ID: ' . $row['youtubegdpr']  . '</b>';
                if ((int) $row['youtubegdpr_previewimage'] > 0) {
                    $resourceFactory = GeneralUtility::makeInstance(ResourceFactory::class);
                    try {
                        $file = $resourceFactory->getFileObject($row['youtubegdpr_previewimage']);
                        $itemContent .= '<br><img src="' . $file->getPublicUrl(true).'" class="img-responsive" style="max-width: 200px">';
                    }
                    catch (\Exception $e) {
                        $itemContent .=  '<br>' . $e->getMessage();
                    }
                }

                $drawItem = false;
            }
        }
    }
}
