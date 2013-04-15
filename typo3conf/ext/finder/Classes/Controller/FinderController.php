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
 * Controller of finder records
 *
 * @package TYPO3
 * @subpackage tx_finder
 */
class Tx_Finder_Controller_FinderController extends Tx_Finder_Controller_FinderBaseController {

	/**
	 * @var \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController
	 */
	protected $typoScriptFrontendController;

	/**
	 * @var Tx_Finder_Domain_Repository_FinderRepository
	 */
	protected $finderRepository;

	/**
	 * @var Tx_Extbase_Configuration_ConfigurationManagerInterface
	 */
	protected $configurationManager;

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
	 * Initializes the current action
	 *
	 * @return void
	 */
	public function initializeAction() {
		if (isset($this->settings['format'])) {
			$this->request->setFormat($this->settings['format']);
		}
		// Only do this in Frontend Context
		if (!empty($GLOBALS['TSFE']) && is_object($GLOBALS['TSFE'])) {
			// We only want to set the tag once in one request, so we have to cache that statically if it has been done
			static $cacheTagsSet = FALSE;

			/** @var $typoScriptFrontendController \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController  */
			$typoScriptFrontendController = $GLOBALS['TSFE'];
			if (!$cacheTagsSet) {
				$typoScriptFrontendController->addCacheTags(array('tx_finder'));
				$cacheTagsSet = TRUE;
			}
			$this->typoScriptFrontendController = $typoScriptFrontendController;
		}

	}

	/**
	 * Create the demand object which define which records will get shown
	 *
	 * @param array $settings
	 * @return Tx_Finder_Domain_Model_Dto_FinderDemand
	 */
	protected function createDemandObjectFromSettings($settings) {
		/* @var $demand Tx_Finder_Domain_Model_Dto_FinderDemand */
		$demand = $this->objectManager->get('Tx_Finder_Domain_Model_Dto_FinderDemand');

		$demand->setCategories(t3lib_div::trimExplode(',', $settings['categories'], TRUE));
		$demand->setCategoryConjunction($settings['categoryConjunction']);
		$demand->setIncludeSubCategories($settings['includeSubCategories']);

		$demand->setTopFinderRestriction($settings['topFinderRestriction']);
		$demand->setTimeRestriction($settings['timeRestriction']);
		$demand->setTimeRestrictionHigh($settings['timeRestrictionHigh']);
		$demand->setArchiveRestriction($settings['archiveRestriction']);
		$demand->setExcludeAlreadyDisplayedFinder($settings['excludeAlreadyDisplayedFinder']);

		if ($settings['orderBy']) {
			$demand->setOrder($settings['orderBy'] . ' ' . $settings['orderDirection']);
		}
		$demand->setOrderByAllowed($settings['orderByAllowed']);

		$demand->setTopFinderFirst($settings['topFinderFirst']);

		$demand->setLimit($settings['limit']);
		$demand->setOffset($settings['offset']);

		$demand->setSearchFields($settings['search']['fields']);
		$demand->setDateField($settings['dateField']);
		$demand->setMonth($settings['month']);
		$demand->setYear($settings['year']);

		$demand->setStoragePage(Tx_Finder_Utility_Page::extendPidListByChildren($settings['startingpoint'],
			$settings['recursive']));
		return $demand;
	}

	/**
	 * Overwrites a given demand object by an propertyName =>  $propertyValue array
	 *
	 * @param Tx_Finder_Domain_Model_Dto_FinderDemand $demand
	 * @param array $overwriteDemand
	 * @return Tx_Finder_Domain_Model_Dto_FinderDemand
	 */
	protected function overwriteDemandObject($demand, $overwriteDemand) {
		unset($overwriteDemand['orderByAllowed']);

		foreach ($overwriteDemand as $propertyName => $propertyValue) {
			Tx_Extbase_Reflection_ObjectAccess::setProperty($demand, $propertyName, $propertyValue);
		}
		return $demand;
	}

	/**
	 * Output a list view of finder
	 *
	 * @param array $overwriteDemand
	 * @return void
	 */
	public function listAction(array $overwriteDemand = NULL) {
		$demand = $this->createDemandObjectFromSettings($this->settings);

		if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
			$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
		}
		$finderRecords = $this->finderRepository->findDemanded($demand);

		$this->view->assignMultiple(array(
			'finder' => $finderRecords,
			'overwriteDemand' => $overwriteDemand,
			'demand' => $demand,
		));
	}

	/**
	 * Single view of a finder record
	 *
	 * @param Tx_Finder_Domain_Model_Finder $finder finder item
	 * @param integer $currentPage current page for optional pagination
	 * @return void
	 */
	public function detailAction(Tx_Finder_Domain_Model_Finder $finder = NULL, $currentPage = 1) {

		if (is_null($finder)) {
			$previewFinderId = ((int)$this->settings['singleFinder'] > 0) ? $this->settings['singleFinder'] : $this->request->getArgument('finder');

			if ($this->settings['previewHiddenRecords']) {
				$finder = $this->finderRepository->findByUid($previewFinderId, FALSE);
			} else {
				$finder = $this->finderRepository->findByUid($previewFinderId);
			}
		}

		$this->view->assignMultiple(array(
			'finderItem' => $finder,
			'currentPage' => (int)$currentPage,
		));

		Tx_Finder_Utility_Page::setRegisterProperties($this->settings['detail']['registerProperties'], $finder);
	}

	/**
	 * Render a menu by dates, e.g. years, months or dates
	 *
	 * @param array|null $overwriteDemand
	 * @return void
	 */
	public function dateMenuAction(array $overwriteDemand = NULL) {
		$demand = $this->createDemandObjectFromSettings($this->settings);

		// It might be that those are set, @see http://forge.typo3.org/issues/44759
		$demand->setLimit(0);
		$demand->setOffset(0);
			// @todo: find a better way to do this related to #13856
		if (!$dateField = $this->settings['dateField']) {
			$dateField = 'datetime';
		}
		$demand->setOrder($dateField . ' ' . $this->settings['orderDirection']);
		$finderRecords = $this->finderRepository->findDemanded($demand);

		$demand->setOrder($this->settings['orderDirection']);
		$statistics = $this->finderRepository->countByDate($demand);

		$this->view->assignMultiple(array(
			'listPid' => ($this->settings['listPid'] ? $this->settings['listPid'] : $GLOBALS['TSFE']->id),
			'dateField' => $dateField,
			'data' => $statistics,
			'finder' => $finderRecords,
			'overwriteDemand' => $overwriteDemand,
			'demand' => $demand,
		));
	}



	/**
	 * Display the search form
	 *
	 * @param Tx_Finder_Domain_Model_Dto_Search $search
	 * @return void
	 */
	public function searchFormAction(Tx_Finder_Domain_Model_Dto_Search $search = NULL) {
		if (is_null($search)) {
			$search = $this->objectManager->get('Tx_Finder_Domain_Model_Dto_Search');
		}

		$this->view->assign('search', $search);
	}

	/**
	 * Displays the search result
	 *
	 * @param Tx_Finder_Domain_Model_Dto_Search $search
	 * @param array $overwriteDemand
	 * @return void
	 */
	public function searchResultAction(Tx_Finder_Domain_Model_Dto_Search $search = NULL, array $overwriteDemand = array()) {
		$demand = $this->createDemandObjectFromSettings($this->settings);
		if ($this->settings['disableOverrideDemand'] != 1 && $overwriteDemand !== NULL) {
			$demand = $this->overwriteDemandObject($demand, $overwriteDemand);
		}

		if (!is_null($search)) {
			$search->setFields($this->settings['search']['fields']);
		}
		$demand->setSearch($search);

		$this->view->assignMultiple(array(
			'finder' => $this->finderRepository->findDemanded($demand),
			'overwriteDemand' => $overwriteDemand,
			'search' => $search,
			'demand' => $demand,
		));
	}

	/***************************************************************************
	 * helper
	 **********************/

	/**
	 * Injects the Configuration Manager and is initializing the framework settings
	 *
	 * @param Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager Instance of the Configuration Manager
	 * @return void
	 */
	public function injectConfigurationManager(Tx_Extbase_Configuration_ConfigurationManagerInterface $configurationManager) {
		$this->configurationManager = $configurationManager;

		$tsSettings = $this->configurationManager->getConfiguration(
				Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_FRAMEWORK,
				'finder',
				'finder_pi1'
			);
		$originalSettings = $this->configurationManager->getConfiguration(
				Tx_Extbase_Configuration_ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS
			);

			// start override
		if (isset($tsSettings['settings']['overrideFlexformSettingsIfEmpty'])) {
			$overrideIfEmpty = t3lib_div::trimExplode(',', $tsSettings['settings']['overrideFlexformSettingsIfEmpty'], TRUE);
			foreach ($overrideIfEmpty as $key) {
					// if flexform setting is empty and value is available in TS
				if ((!isset($originalSettings[$key]) || empty($originalSettings[$key]))
						&& isset($tsSettings['settings'][$key])) {
					$originalSettings[$key] = $tsSettings['settings'][$key];
				}
			}
		}

			// Use stdWrap for given defined settings
		if (isset($originalSettings['useStdWrap']) && !empty($originalSettings['useStdWrap'])) {
			$typoScriptService = t3lib_div::makeInstance('Tx_Extbase_Service_TypoScriptService');
			$typoScriptArray = $typoScriptService->convertPlainArrayToTypoScriptArray($originalSettings);
			$stdWrapProperties = t3lib_div::trimExplode(',', $originalSettings['useStdWrap'], TRUE);
			foreach ($stdWrapProperties as $key) {
				if (is_array($typoScriptArray[$key . '.'])) {
					$originalSettings[$key] = $this->configurationManager->getContentObject()->stdWrap(
							$originalSettings[$key],
							$typoScriptArray[$key . '.']
					);
				}
			}
		}

		$this->settings = $originalSettings;
	}

	/**
	 * Injects a view.
	 * This function is for testing purposes only.
	 *
	 * @param Tx_Fluid_View_TemplateView $view the view to inject
	 * @return void
	 */
	public function setView(Tx_Fluid_View_TemplateView $view) {
		$this->view = $view;
	}

}
?>