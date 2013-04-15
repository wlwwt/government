<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2011 Alexander Buchgeher
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
 * Utility class to get the settings from Extension Manager
 *
 * @package TYPO3
 * @subpackage tx_finder
 * @author Alexander Buchgeher
 * @author finder
 */
class Tx_Finder_Utility_EmConfiguration {

	/**
	 * Parses the extension settings.
	 *
	 * @return Tx_Finder_Domain_Model_Dto_EmConfiguration
	 * @throws Exception If the configuration is invalid.
	 */
	public static function getSettings() {
		$configuration = self::parseSettings();
		$settings = new Tx_Finder_Domain_Model_Dto_EmConfiguration($configuration);
		return $settings;
	}

	/**
	 * Parse settings and return it as array
	 *
	 * @return array unserialized extconf settings
	 */
	public static function parseSettings() {
		$settings = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['finder']);

		if (!is_array($settings)) {
			$settings = array();
		}
		return $settings;
	}

}

?>