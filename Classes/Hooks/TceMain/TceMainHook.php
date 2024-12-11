<?php
namespace SaschaSchieferdecker\YoutubeGdprembed\Hooks\TceMain;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

class TceMainHook
{
    /**
     * Resets preview image if video ID is changed - does not delete any images
     * @param $status
     * @param $table
     * @param $id
     * @param array $fieldArray
     * @param \TYPO3\CMS\Core\DataHandling\DataHandler $pObj
     */
    public function processDatamap_afterDatabaseOperations($status, $table, $id, array $fieldArray, \TYPO3\CMS\Core\DataHandling\DataHandler &$pObj): void {
        if ($status === 'update' && array_key_exists('youtubegdpr', $fieldArray)) {
            // Previewimage has to be updated
            $databaseConnection = GeneralUtility::makeInstance(ConnectionPool::class)
                ->getConnectionForTable('tt_content');
            $where = ['uid' => (int) $id];
            $data = [
                'youtubegdpr_previewimage' => null,
                'youtubegdpr_width' => 0,
                'youtubegdpr_height' => 0
            ];
            $databaseConnection->update('tt_content', $data, $where);
        }
    }
}
