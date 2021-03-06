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
 * Implementation of video portal support
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_MediaRenderer_Video_Videosites implements Tx_Finder_MediaRenderer_MediaInterface {

	/**
	 * Render videos from various video portals
	 *
	 * @param Tx_Finder_Domain_Model_Media $element
	 * @param integer $width
	 * @param integer $height
	 * @return string
	 */
	public function render(Tx_Finder_Domain_Model_Media $element, $width, $height) {
		$content = $finalUrl = '';
		$url = Tx_Finder_Service_FileService::getCorrectUrl($element->getContent());

			// get the correct rewritten url
		$mediaWizard = tslib_mediaWizardManager::getValidMediaWizardProvider($url);
		if ($mediaWizard !== NULL) {
			$finalUrl = $mediaWizard->rewriteUrl($url);
		}

			// override width & height if both are set
		if ($element->getWidth() > 0 && $element->getHeight() > 0) {
			$width = $element->getWidth();
			$height = $element->getHeight();
		}

		if (!empty($finalUrl)) {
			$GLOBALS['TSFE']->getPageRenderer()->addJsFile('typo3conf/ext/finder/Resources/Public/JavaScript/Contrib/swfobject-2-2.js');
			$uniqueDivId = 'mediaelement' . Tx_Finder_Service_FileService::getUniqueId($element);

			$content .= '<div id="' . htmlspecialchars($uniqueDivId) . '"></div>
						<script type="text/javascript">
							var params = { allowScriptAccess: "always" };
							var atts = { id: ' . t3lib_div::quoteJSvalue($uniqueDivId) . ' };
							swfobject.embedSWF(' . t3lib_div::quoteJSvalue($finalUrl) . ',
							' . t3lib_div::quoteJSvalue($uniqueDivId) . ', "' . (int)$width . '", "' . (int)$height . '", "8", null, null, params, atts);
						</script>';
		}

		return $content;
	}

	/**
	 * Videosites implementation is always enabled if any file given,
	 * the check is done in tslib_mediaWizardManager
	 *
	 * @param Tx_Finder_Domain_Model_Media $element
	 * @return boolean
	 */
	public function enabled(Tx_Finder_Domain_Model_Media $element) {
		$result = TRUE;
		$file = $element->getContent();
		if (empty($file)) {
			$result = FALSE;
		}
		return $result;
	}

}

?>