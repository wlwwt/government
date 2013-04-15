<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

	// Extension manager configuration
$configuration = Tx_Finder_Utility_EmConfiguration::getSettings();
	// Alternative labels for finder & category records
t3lib_div::requireOnce(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Hooks/Labels.php');
	// Add additional media types like DAM
t3lib_div::requireOnce(t3lib_extMgm::extPath($_EXTKEY) . 'Classes/Hooks/ItemsProcFunc.php');
	// CSH - context sensitive help
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_finder', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_finder.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_category', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_category.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_media', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_media.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_file', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_file.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_link', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_link.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tx_finder_domain_model_tag', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_tag.xml');
t3lib_extMgm::addLLrefForTCAdescr(
		'tt_content.pi_flexform.finder_pi1.list', 'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_flexforms.xml');

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_finder');

$TCA['tx_finder_domain_model_finder'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_finder',
		'label'     => 'title',
		'prependAtCopy' => $configuration->getPrependAtCopy() ? 'LLL:EXT:lang/locallang_general.xml:LGL.prependAtCopy' : '',
		'hideAtCopy' => TRUE,
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'versioningWS' => TRUE,
		'origUid' => 't3_origuid',
		'editlock' => 'editlock',
		'type' => 'type',
		'typeicon_column' => 'type',
		'typeicons' => array (
			'1' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_finder_internal.gif',
			'2' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_finder_external.gif',
		),
		'dividers2tabs' => TRUE,
		'useColumnsForDefaultValues' => 'type',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY datetime DESC',
		'sortby' => ($configuration->getManualSorting() ? 'sorting' : ''),
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/finder.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_finder.gif',
		'searchFields' => 'uid,title',
		'requestUpdate' => 'rte_disabled',
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_category');

$TCA['tx_finder_domain_model_category'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_category',
		'label'     => 'title',
		'label_alt' => 'parentcategory,sys_language_uid',
		'label_alt_force' => 1,
		'label_userFunc' => 'Tx_Finder_Hooks_Labels->getUserLabelCategory',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'default_sortby' => 'ORDER BY crdate',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/category.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_category.gif',
		'treeParentField' => 'parentcategory',
		'searchFields' => 'uid,title',
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_media');

$TCA['tx_finder_domain_model_media'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_media',
		'label'     => 'caption',
		'label_alt' => 'type, showinpreview',
		'label_alt_force' => 1,
		'label_userFunc' => 'Tx_Finder_Hooks_Labels->getUserLabelMedia',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY sorting',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/media.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_media.gif',
		'hideTable'			=> TRUE,
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_media');

$TCA['tx_finder_domain_model_file'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_file',
		'label'     => 'title',
		'label_alt' => 'file',
		'label_alt_force' => 1,
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY sorting',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/file.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_file.gif',
		'hideTable'			=> TRUE,
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_file');

$TCA['tx_finder_domain_model_link'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_link',
		'label'     => 'title',
		'label_alt' => 'uri',
		'label_alt_force' => 1,
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'type' => 'type',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY sorting',
		'sortby' => 'sorting',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/link.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_link.gif',
		'hideTable'			=> TRUE,
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_link');

$TCA['tx_finder_domain_model_tag'] = array(
	'ctrl' => array(
		'title'     => 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:tx_finder_domain_model_tag',
		'label'     => 'title',
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'default_sortby' => 'ORDER BY title',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/Tca/tag.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/finder_domain_model_tag.png',
		'searchFields' => 'uid,title',
	),
);

t3lib_extMgm::allowTableOnStandardPages('tx_finder_domain_model_tag');

/***************
 * Plugin
 */
Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Pi1',
		'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_be.xml:pi1_title'
);


$extensionName = t3lib_div::underscoredToUpperCamelCase($_EXTKEY);
$pluginSignature = strtolower($extensionName) . '_pi1';

$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$pluginSignature] = 'layout,recursive,select_key,pages';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
t3lib_extMgm::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_finder.xml');


/***************
 * Default TypoScript
 */
t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Finder');

/***************
 * Wizard pi1
 */
if (TYPO3_MODE == 'BE') {
	$TBE_MODULES_EXT['xMOD_db_new_content_el']['addElClasses'][$pluginSignature . '_wizicon'] =
		t3lib_extMgm::extPath($_EXTKEY) . 'Resources/Private/Php/class.' . $_EXTKEY . '_wizicon.php';
}

/***************
 * Finder icon in page tree
 */
if (TYPO3_MODE == 'BE') {
	unset($ICON_TYPES['finder']);
	t3lib_SpriteManager::addTcaTypeIcon('pages', 'contains-finder', '../typo3conf/ext/finder/Resources/Public/Icons/folder.gif');

	$addFinderToModuleSelection = TRUE;
	foreach ($GLOBALS['TCA']['pages']['columns']['module']['config']['items'] as $item) {
		if ($item[1] === 'finder') {
			$addFinderToModuleSelection = FALSE;
			continue;
		}
	}
	if ($addFinderToModuleSelection) {
		$GLOBALS['TCA']['pages']['columns']['module']['config']['items'][] = array(
			0 => 'LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:finder-folder',
			1 => 'finder',
			2 => '../typo3conf/ext/finder/Resources/Public/Icons/folder.gif'
		);
	}
}


/***************
 * Show finder table in page module
 */
if ($configuration->getPageModuleFieldsFinder()) {
	$addTableItems = t3lib_div::trimExplode(';', $configuration->getPageModuleFieldsFinder(), TRUE);
	foreach ($addTableItems as $item) {
		$split = t3lib_div::trimExplode('=', $item, TRUE);
		$fList = $fTitle = '';
		if (count($split) == 2) {
			$fTitle = $split[0];
			$fList = $split[1];
		} else {
			$fList = $split[0];
		}
		$TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tx_finder_domain_model_finder'][] = array(
			'MENU' => $fTitle,
			'fList' => $fList,
			'icon' => TRUE,
		);
	}

}

if ($configuration->getPageModuleFieldsCategory()) {
	$TYPO3_CONF_VARS['EXTCONF']['cms']['db_layout']['addTables']['tx_finder_domain_model_category'][0] = array(
		'fList' => htmlspecialchars($configuration->getPageModuleFieldsCategory()),
		'icon' => TRUE
	);
}


	// extend user settings
$GLOBALS['TYPO3_USER_SETTINGS']['columns']['finderoverlay'] = array(
	'label'			=> 'LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:usersettings.overlay',
	'type'			=> 'select',
	'itemsProcFunc'	=> 'Tx_Finder_Hooks_ItemsProcFunc->user_categoryOverlay',
);
$GLOBALS['TYPO3_USER_SETTINGS']['showitem'] .= ',
	--div--;LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:pi1_title,finderoverlay';

// Add tables to livesearch (e.g. "#finder:fo" or "#findercat:fo")
$GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['finder'] = 'tx_finder_domain_model_finder';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['findercat'] = 'tx_finder_domain_model_category';
$GLOBALS['TYPO3_CONF_VARS']['SYS']['livesearch']['findertag'] = 'tx_finder_domain_model_tag';

/* ===========================================================================
 	Register BE-Modules
=========================================================================== */
if (TYPO3_MODE === 'BE' && $configuration->getShowImporter()) {
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',
		'tx_finder_m1',
		'',
		array(
			'Import' => 'index, runJob, jobInfo',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/import_module.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_mod.xml',
		)
	);

		// show tt_finder importer only if tt_finder is installed
	if (t3lib_extMgm::isLoaded('tt_finder')) {
		Tx_Finder_Utility_ImportJob::register(
			'Tx_Finder_Jobs_TTFinderFinderImportJob',
			'LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:ttfinder_importer_title',
			'');
		Tx_Finder_Utility_ImportJob::register(
			'Tx_Finder_Jobs_TTFinderCategoryImportJob',
			'LLL:EXT:finder/Resources/Private/Language/locallang_be.xml:ttfindercategory_importer_title',
			'');
	}
}


/* ===========================================================================
 	Register BE-Module for Administration
=========================================================================== */
if (TYPO3_MODE === 'BE' && $configuration->getShowAdministrationModule()) {
	Tx_Extbase_Utility_Extension::registerModule(
		$_EXTKEY,
		'web',
		'tx_finder_m2',
		'',
		array(
			'Administration' => 'index,newFinder,newCategory,finderPidListing',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Resources/Public/Icons/folder.gif',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_modadministration.xml',
		)
	);
}

/* ===========================================================================
 	Ajax call to save tags
=========================================================================== */
if (TYPO3_MODE == 'BE') {
	$GLOBALS['TYPO3_CONF_VARS']['BE']['AJAX']['Finder::createTag'] = 'typo3conf/ext/finder/Classes/Hooks/SuggestReceiverCall.php:Tx_Finder_Hooks_SuggestReceiverCall->createTag';
}

/* ===========================================================================
 	Default configuration
=========================================================================== */
$GLOBALS['TYPO3_CONF_VARS']['EXT']['finder']['orderByCategory'] = 'uid,title,tstamp,sorting';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['finder']['orderByFinder'] = 'tstamp,datetime,crdate,title';
$GLOBALS['TYPO3_CONF_VARS']['EXT']['finder']['switchableControllerActions']['list'] = $configuration->getRemoveListActionFromFlexforms();

/* ===========================================================================
 	Extend be_user/be_groups table by a category restriction
=========================================================================== */
$tempColumns = array(
	'tx_finder_categorymounts' => array(
		'exclude' => 1,
		'label' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_db.xml:be_user.tx_finder_categorymounts',
		'config' => array(
			'type' => 'select',
			'foreign_table' => 'tx_finder_domain_model_category',
			'foreign_table_where' => ' AND (tx_finder_domain_model_category.sys_language_uid = 0 OR tx_finder_domain_model_category.l10n_parent = 0) ORDER BY tx_finder_domain_model_category.sorting',
			'renderMode' => 'tree',
			'subType' => 'db',
			'treeConfig' => array(
				'parentField' => 'parentcategory',
				'appearance' => array(
					'expandAll' => TRUE,
					'showHeader' => FALSE,
					'maxLevels' => 99,
				),
			),
			'size' => 10,
			'autoSizeMax' => 20,
			'minitems' => 0,
			'maxitems' => 99
		)
	)
);


t3lib_div::loadTCA('be_groups');
t3lib_extMgm::addTCAcolumns('be_groups', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('be_groups', 'tx_finder_categorymounts;;;;1-1-1');

t3lib_div::loadTCA('be_users');
t3lib_extMgm::addTCAcolumns('be_users', $tempColumns, 1);
t3lib_extMgm::addToAllTCAtypes('be_users', 'tx_finder_categorymounts;;;;1-1-1');
?>