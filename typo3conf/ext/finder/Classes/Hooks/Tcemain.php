<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 finder
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

/**
 * Hook into tcemain which is used to show preview of finder item
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_Hooks_Tcemain {

	/**
	 * Generate a different preview link
	 *
	 * @param string $status status
	 * @param string $table table name
	 * @param integer $recordUid id of the record
	 * @param array $fields fieldArray
	 * @param t3lib_TCEmain $parentObject parent Object
	 * @return void
	 */
	public function processDatamap_afterDatabaseOperations($status, $table, $recordUid, array $fields, t3lib_TCEmain $parentObject) {
			// Clear category cache
		if ($table === 'tx_finder_domain_model_category') {
			$cache = t3lib_div::makeInstance('Tx_Finder_Service_CacheService', 'finder_categorycache');
			$cache->flush();
		}

			// Preview link
		if ($table === 'tx_finder_domain_model_finder') {

				// direct preview
			if (!is_numeric($recordUid)) {
				$recordUid = $parentObject->substNEWwithIDs[$recordUid];
			}

			if (isset($GLOBALS['_POST']['_savedokview_x']) && !$fields['type']) {
				// If "savedokview" has been pressed and current article has "type" 0 (= normal finder article)
				$pagesTsConfig = t3lib_BEfunc::getPagesTSconfig($GLOBALS['_POST']['popViewId']);
				if ($pagesTsConfig['tx_finder.']['singlePid']) {
					$record = t3lib_BEfunc::getRecord('tx_finder_domain_model_finder', $recordUid);

					$params = '&no_cache=1&tx_finder_pi1[controller]=Finder&tx_finder_pi1[action]=detail';
					if ($record['sys_language_uid'] > 0) {
						if ($record['l10n_parent'] > 0) {
							$params .= '&tx_finder_pi1[finder]=' . $record['l10n_parent'];
						} else {
							$params .= '&tx_finder_pi1[finder]=' . $record['uid'];
						}

						$params .= '&L=' . $record['sys_language_uid'];
					} else {
							$params .= '&tx_finder_pi1[finder]=' . $record['uid'];
					}

					$GLOBALS['_POST']['popViewId_addParams'] = $params;
					$GLOBALS['_POST']['popViewId'] = $pagesTsConfig['tx_finder.']['singlePid'];
				}
			}
		}
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/finder/Classes/Hooks/Tcemain.php']) {
	require_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/finder/Classes/Hooks/Tcemain.php']);
}

?>