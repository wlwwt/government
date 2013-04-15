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
 * Administration controller
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_Controller_AdministrationController extends Tx_Finder_Controller_FinderController {

	/**
	 * Page uid
	 *
	 * @var integer
	 */
	protected $pageUid = 0;

	/**
	 * @var Tx_Finder_Domain_Repository_FinderRepository
	 */
	protected $finderRepository;

	/**
	 * @var Tx_Finder_Domain_Repository_CategoryRepository
	 */
	protected $categoryRepository;

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

	/**
	 * Function will be called before every other action
	 *
	 * @return void
	 */
	public function initializeAction() {
		$this->pageUid = (int)t3lib_div::_GET('id');
		parent::initializeAction();
	}

	/**
	 * Inject a finder repository to enable DI
	 *
	 * @param Tx_Finder_Domain_Repository_FinderRepository $finderRepository
	 * @return void
	 */
	public function injectFinderRepository(Tx_Finder_Domain_Repository_FinderRepository $finderRepository) {
		$this->finderRepository = $finderRepository;
	}

	/**
	 * Inject a finder repository to enable DI
	 *
	 * @param Tx_Finder_Domain_Repository_CategoryRepository $categoryRepository
	 * @return void
	 */
	public function injectCategoryRepository(Tx_Finder_Domain_Repository_CategoryRepository $categoryRepository) {
		$this->categoryRepository = $categoryRepository;
	}

	/**
	 * Main action for administration
	 *
	 * @param Tx_Finder_Domain_Model_Dto_AdministrationDemand $demand
	 * @dontvalidate  $demand
	 * @return void
	 */
	public function indexAction(Tx_Finder_Domain_Model_Dto_AdministrationDemand $demand = NULL) {
		if (is_null($demand)) {
			$demand = $this->objectManager->get('Tx_Finder_Domain_Model_Dto_AdministrationDemand');

				// Preselect by TsConfig (e.g. tx_finder.module.preselect.topFinderRestriction = 1)
			$tsConfig = t3lib_BEfunc::getPagesTSconfig($this->pageUid);
			if (isset($tsConfig['tx_finder.']['module.']['preselect.'])
					&& is_array($tsConfig['tx_finder.']['module.']['preselect.'])) {
				unset($tsConfig['tx_finder.']['module.']['preselect.']['orderByAllowed']);

				foreach ($tsConfig['tx_finder.']['module.']['preselect.'] as $propertyName => $propertyValue) {
					Tx_Extbase_Reflection_ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
				}
			}
		}
		$demand = $this->createDemandObjectFromSettings($demand);

		$categories = $this->categoryRepository->findParentCategoriesByPid($this->pageUid);
		$idList = array();
		foreach ($categories as $c) {
			$idList[] = $c->getUid();
		}

		$this->view->assignMultiple(array(
			'demand' => $demand,
			'finder' => $this->finderRepository->findDemanded($demand, FALSE),
			'categories' => $this->categoryRepository->findTree($idList),
		));
	}

	/**
	 * Shows a page tree including count of finder + category records
	 *
	 * @param integer $treeLevel
	 * @return void
	 */
	public function finderPidListingAction($treeLevel = 2) {
		$tree = Tx_Finder_Utility_Page::pageTree($this->pageUid, $treeLevel);

		$rawTree = array();
		foreach ($tree->tree as $row) {
			$this->countRecordsOnPage($row);
			$rawTree[] = $row;
		}

		$this->view->assignMultiple(array(
			'tree' => $rawTree,
			'treeLevel' => $treeLevel,
		));
	}

	/**
	 * Redirect to form to create a finder record
	 *
	 * @return void
	 */
	public function newFinderAction() {
		$this->redirectToCreateNewRecord('tx_finder_domain_model_finder');
	}

	/**
	 * Redirect to form to create a category record
	 *
	 * @return void
	 */
	public function newCategoryAction() {
		$this->redirectToCreateNewRecord('tx_finder_domain_model_category');
	}

	/**
	 * Create the demand object which define which records will get shown
	 *
	 * @param Tx_Finder_Domain_Model_Dto_AdministrationDemand $demand
	 * @return Tx_Finder_Domain_Model_Dto_FinderDemand
	 */
	protected function createDemandObjectFromSettings(Tx_Finder_Domain_Model_Dto_AdministrationDemand $demand) {
		$demand->setCategories($demand->getSelectedCategories());
		$demand->setOrder($demand->getSortingField() . ' ' . $demand->getSortingDirection());
		$demand->setStoragePage(Tx_Finder_Utility_Page::extendPidListByChildren($this->pageUid, (int)$demand->getRecursive()));
		$demand->setOrderByAllowed($this->settings['orderByAllowed']);

		if ((int)$demand->getLimit() === 0) {
			$demand->setLimit(50);
		}

		return $demand;
	}

	/**
	 * Update page record array with count of finder & category records
	 *
	 * @param array $row page record
	 * @return void
	 */
	private function countRecordsOnPage(array &$row) {
		$pageUid = (int)$row['row']['uid'];

		/* @var $db t3lib_DB */
		$db = $GLOBALS['TYPO3_DB'];

		$row['countFinder'] = $db->exec_SELECTcountRows(
			'*',
			'tx_finder_domain_model_finder',
			'pid=' . $pageUid . t3lib_BEfunc::BEenableFields('tx_finder_domain_model_finder'));
		$row['countCategories'] = $db->exec_SELECTcountRows(
			'*',
			'tx_finder_domain_model_category',
			'pid=' . $pageUid . t3lib_BEfunc::BEenableFields('tx_finder_domain_model_category'));

		$row['countFinderAndCategories'] = ($row['countFinder'] + $row['countCategories']);
	}

	/**
	 * Redirect to tceform creating a new record
	 *
	 * @param string $table table name
	 * @return void
	 */
	private function redirectToCreateNewRecord($table) {
		$returnUrl = 'mod.php?M=web_FinderTxFinderM2&id=' . $this->pageUid;
		$url = 'alt_doc.php?edit[' . $table . '][' . $this->pageUid . ']=new&returnUrl=' . urlencode($returnUrl);

		t3lib_utility_Http::redirect($url);
	}
}

?>