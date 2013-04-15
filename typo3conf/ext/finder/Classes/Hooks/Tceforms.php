<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2012 finder
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
 * Hook into tceforms
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_Hooks_Tceforms {

	/**
	 * Preprocessing of fields
	 *
	 * @param string $table table name
	 * @param string $field field name
	 * @param array $row record row
	 * @param string $altName
	 * @param string $palette
	 * @param string $extra
	 * @param string $pal
	 * @param t3lib_TCEforms $parentObject
	 * @return void
	 */
	public function getSingleField_preProcess($table, $field, array &$row, $altName, $palette, $extra, $pal, t3lib_TCEforms $parentObject) {
			// Predefine the archive date
		if ($table === 'tx_finder_domain_model_finder' && !is_numeric($row['uid'])) {
			$pagesTsConfig = t3lib_BEfunc::getPagesTSconfig($row['pid']);

			if (is_array($pagesTsConfig['tx_finder.']['predefine.'])
					&& is_array($pagesTsConfig['tx_finder.']['predefine.'])
					&& isset($pagesTsConfig['tx_finder.']['predefine.']['archive'])) {
				$calculatedTime = strtotime($pagesTsConfig['tx_finder.']['predefine.']['archive']);

				if ($calculatedTime !== FALSE) {
					$row['archive'] = $calculatedTime;
				}
			}
		}
	}

}


if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/finder/Classes/Hooks/Tceforms.php']) {
	require_once ($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/finder/Classes/Hooks/Tceforms.php']);
}

?>