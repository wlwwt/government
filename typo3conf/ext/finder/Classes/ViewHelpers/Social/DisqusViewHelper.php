<?php
/***************************************************************
 *  Copyright notice
 *  (c) 2010 finder
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * ViewHelper to add disqus thread
 * Details: http://www.disqus.com/
 * Example
 * ==============
 * <div id="disqus_thread"></div>
 * <n:social.disqus finderItem="{finderItem}"
 *         shortName="demo123"
 *         link="{n:link(finderItem:finderItem,settings:settings,uriOnly:1)}" />
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_ViewHelpers_Social_DisqusViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	protected $escapingInterceptorEnabled = FALSE;

	/**
	 * @var Tx_Finder_Service_SettingsService
	 */
	protected $pluginSettingsService;

	/**
	 * @var Tx_Finder_Service_SettingsService $pluginSettingsService
	 * @return void
	 */
	public function injectSettingsService(Tx_Finder_Service_SettingsService $pluginSettingsService) {
		$this->pluginSettingsService = $pluginSettingsService;
	}

	/**
	 * Render disqus thread
	 *
	 * @param Tx_Finder_Domain_Model_Finder $finderItem finder item
	 * @param string $shortName shortname
	 * @param string $link link
	 * @return string
	 */
	public function render(Tx_Finder_Domain_Model_Finder $finderItem, $shortName, $link) {
		$tsSettings = $this->pluginSettingsService->getSettings();

		$code = '<script type="text/javascript">
					var disqus_shortname = ' . t3lib_div::quoteJSvalue($shortName, TRUE) . ';
					var disqus_identifier = \'finder_' . $finderItem->getUid() . '\';
					var disqus_url = ' . t3lib_div::quoteJSvalue($link, TRUE) . ';
					var disqus_title = ' . t3lib_div::quoteJSvalue($finderItem->getTitle(), TRUE) . ';
					var disqus_config = function () {
						this.language = ' . t3lib_div::quoteJSvalue($tsSettings['disqusLang']) . ';
					};

					(function() {
						var dsq = document.createElement("script"); dsq.type = "text/javascript"; dsq.async = true;
						dsq.src = "http://" + disqus_shortname + ".disqus.com/embed.js";
						(document.getElementsByTagName("head")[0] || document.getElementsByTagName("body")[0]).appendChild(dsq);
					})();
				</script>';

		return $code;
	}
}

?>