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
 * Ajax response for the custom suggest receiver
 *
 * @author	finder
 * @package	TYPO3
 * @subpackage	tx_finder
 */
class Tx_Finder_Hooks_SuggestReceiverCall {

	const TAG = 'tx_finder_domain_model_tag';
	const NEWS = 'tx_finder_domain_model_finder';
	const LLPATH = 'LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:tag_suggest_';

	/**
	 * Create a tag
	 *
	 * @param array $params
	 * @param TYPO3AJAX $ajaxObj
	 * @return void
	 */
	public function createTag(array $params, TYPO3AJAX $ajaxObj) {
		$request = t3lib_div::_POST();

		try {
				// Check if a tag is submitted
			if (!isset($request['item']) || empty($request['item'])) {
				throw new Exception('error_no-tag');
			}

			$finderUid = $request['finderid'];
			if ((int)$finderUid === 0 && (strlen($finderUid) == 16 && !t3lib_div::isFirstPartOfStr($finderUid, 'NEW'))) {
				throw new Exception('error_no-finderid');
			}

				// Get tag uid
			$newTagId = $this->getTagUid($request);

			$ajaxObj->setContentFormat('javascript');
			$ajaxObj->setContent('');
			$response = array(
				$newTagId,
				$request['item'],
				self::TAG,
				self::NEWS,
				'tags',
				'data[tx_finder_domain_model_finder][' . $finderUid . '][tags]',
				$finderUid
			);
			$ajaxObj->setJavascriptCallbackWrap(implode('-', $response));
		} catch (Exception $e) {
			$errorMsg = $GLOBALS['LANG']->sL(self::LLPATH . $e->getMessage());
			$ajaxObj->setError($errorMsg);
		}
	}

	/**
	 * Get the uid of the tag, either bei inserting as new or get existing
	 *
	 * @param array $request ajax request
	 * @return integer
	 */
	protected function getTagUid(array $request) {
		$tagUid = 0;

			// Get configuration from EM
		$configuration = Tx_Finder_Utility_EmConfiguration::getSettings();

		$pid = $configuration->getTagPid();
		if ($pid === 0) {
			$pid = $this->getTagPidFromTsConfig($request['finderid']);
		}

		if ($pid === 0) {
			throw new Exception('error_no-pid-defined');
		}

		$record = $GLOBALS['TYPO3_DB']->exec_SELECTgetSingleRow(
					'*',
					self::TAG,
					'deleted=0 AND pid=' . $pid .
						' AND title=' . $GLOBALS['TYPO3_DB']->fullQuoteStr($request['item'], self::TAG)
					);
		if (isset($record['uid'])) {
			$tagUid = $record['uid'];
		} else {
			$tcemainData = array(
				self::TAG => array(
					'NEW' => array(
						'pid' => $pid,
						'title' => $request['item']
					)
				)
			);

			/**
			 * @var t3lib_TCEmain
			 */
			$tce = t3lib_div::makeInstance('t3lib_TCEmain');
			$tce->start($tcemainData, array());
			$tce->process_datamap();

			$tagUid = $tce->substNEWwithIDs['NEW'];
		}

		if ($tagUid == 0) {
			throw new Exception('error_no-tag-created');
		}

		return $tagUid;
	}

	/**
	 * Get pid for tags from TsConfig
	 *
	 * @param integer $finderUid uid of current finder record
	 * @return int
	 */
	protected function getTagPidFromTsConfig($finderUid) {
		$pid = 0;

		$finderRecord = t3lib_BEfunc::getRecord('tx_finder_domain_model_finder', (int)$finderUid);

		$pagesTsConfig = t3lib_BEfunc::getPagesTSconfig($finderRecord['pid']);
		if (isset($pagesTsConfig['tx_finder.']) && isset($pagesTsConfig['tx_finder.']['tagPid'])) {
			$pid = (int)$pagesTsConfig['tx_finder.']['tagPid'];
		}

		return $pid;
	}

}

?>