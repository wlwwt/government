<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2010 finder
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
 * Implementation of file support
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_MediaRenderer_Video_File implements Tx_Finder_MediaRenderer_MediaInterface {

	const PATH_TO_JS = 'typo3conf/ext/finder/Resources/Public/JavaScript/Contrib/';

	/**
	 * Render a video player
	 *
	 * @param Tx_Finder_Domain_Model_Media $element
	 * @param integer $width
	 * @param integer $height
	 * @param string $templateFile template file to override. Absolute path
	 * @return string
	 */
	public function render(Tx_Finder_Domain_Model_Media $element, $width, $height, $templateFile = '' ) {
		$view = t3lib_div::makeInstance('Tx_Fluid_View_StandaloneView');
		if (!$templateFile || !is_readable($templateFile)) {
			$view->setTemplatePathAndFilename(t3lib_extMgm::extPath('finder') . 'Resources/Private/Templates/ViewHelpers/Flv.html');
		} else {
			$view->setTemplatePathAndFilename($templateFile);
		}

		$url = Tx_Finder_Service_FileService::getCorrectUrl($element->getContent());

		$GLOBALS['TSFE']->getPageRenderer()->addJsFile(self::PATH_TO_JS . 'flowplayer-3.2.4.min.js');

			// override width & height if both are set
		if ($element->getWidth() > 0 && $element->getHeight() > 0) {
			$width = $element->getWidth();
			$height = $element->getHeight();
		}

		$view->assign('width', Tx_Finder_Utility_Compatibility::convertToPositiveInteger($width));
		$view->assign('height', Tx_Finder_Utility_Compatibility::convertToPositiveInteger($height));
		$view->assign('uniqueDivId', 'mediaelement-' . Tx_Finder_Service_FileService::getUniqueId($element));
		$view->assign('url', $url);

		return $view->render();
	}

	/**
	 * Files with extension flv|mp4 are handled within this implementation
	 *
	 * @param Tx_Finder_Domain_Model_Media $element
	 * @return boolean
	 */
	public function enabled(Tx_Finder_Domain_Model_Media $element) {
		$url = $element->getMultimedia();
		$fileEnding = strtolower(substr($url, -3));

		$enabled = FALSE;
		if ($fileEnding === 'flv' || $fileEnding === 'mp4') {
			$enabled = TRUE;
		}

		return $enabled;
	}

}

?>