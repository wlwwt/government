<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$ll = 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:';

// Extension manager configuration
$configuration = Tx_Finder_Utility_EmConfiguration::getSettings();

$TCA['tx_finder_domain_model_finder'] = array(
	'ctrl' => $TCA['tx_finder_domain_model_finder']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'cruser_id,pid,sys_language_uid,l10n_parent,l10n_diffsource,hidden,starttime,endtime,title,bodytext,datetime,categories,related,type,keywords,media,internalurl,externalurl,istopfinder,related_files,related_links,content_elements,path_segment,alternative_title'
	),
	'feInterface' => $TCA['tx_finder_domain_model_finder']['feInterface'],
	'columns' => array(
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:sys_language_uid_formlabel',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_finder_domain_model_finder',
				'foreign_table_where' => 'AND tx_finder_domain_model_finder.pid=###CURRENT_PID### AND tx_finder_domain_model_finder.sys_language_uid IN (-1,0)',
			)
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'cruser_id' => array(
			'label' => 'cruser_id',
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'is_dummy_record' => array(
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'pid' => array(
			'label' => 'pid',
			'config' => array(
				'type' => 'passthrough'
			)
		),
		'crdate' => array(
			'label' => 'crdate',
			'config' => array(
				'type' => 'passthrough',
			)
		),
		'tstamp' => array(
			'label' => 'crdate',
			'config' => array(
				'type' => 'passthrough',
			)
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel',
			'config' => array(
				'type' => 'input',
				'size' => 8,
				'max' => 20,
				'eval' => 'date',
				'default' => 0,
			)
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel',
			'config' => array(
				'type' => 'input',
				'size' => 8,
				'max' => 20,
				'eval' => 'date',
				'default' => 0,
			)
		),
		'title' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:header_formlabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'required',
			)
		),
		'alternative_title' => array(
			'exclude' => 0,
			'label' => $ll . 'tx_finder_domain_model_finder.alternative_title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			)
		),
		'bodytext' => array(
			'exclude' => 0,
			'l10n_mode' => 'noCopy',
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:bodytext_formlabel',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 5,
				'wizards' => array(
					'_PADDING' => 2,
					'RTE' => array(
						'notNewRecords' => 1,
						'RTEonly' => 1,
						'type' => 'script',
						'title' => 'Full screen Rich Text Editing',
						'icon' => 'wizard_rte2.gif',
						'script' => 'wizard_rte.php',
					),
				),
			)
		),
		'rte_disabled' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:cms/locallang_ttc.xml:rte_enabled',
			'config' => array(
				'type' => 'check',
				'showIfRTE' => 1,
				'items' => array(
					'1' => array(
						'0' => 'LLL:EXT:cms/locallang_ttc.xml:rte_enabled.I.0'
					)
				)
			)
		),
		'datetime' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.datetime',
			'config' => array(
				'type' => 'input',
				'size' => 12,
				'max' => 20,
				'eval' => 'datetime,required',
				'default' => mktime(date('H'), date('i'), 0, date('m'), date('d'), date('Y'))
			)
		),
		'categories' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.categories',
			'config' => array(
				'type' => 'select',
				'renderMode' => 'tree',
				'treeConfig' => array(
					'dataProvider' => 'Tx_Finder_TreeProvider_DatabaseTreeDataProvider',
					'parentField' => 'parentcategory',
					'appearance' => array(
						'showHeader' => TRUE,
						'allowRecursiveMode' => TRUE,
					),
				),
				'MM' => 'tx_finder_domain_model_finder_category_mm',
				'foreign_table' => 'tx_finder_domain_model_category',
				'foreign_table_where' => ' AND (tx_finder_domain_model_category.sys_language_uid = 0 OR tx_finder_domain_model_category.l10n_parent = 0) ORDER BY tx_finder_domain_model_category.sorting',
				'size' => 10,
				'autoSizeMax' => 20,
				'minitems' => 0,
				'maxitems' => 20,
			)
		),
		'related' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.related',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'tx_finder_domain_model_finder',
				'foreign_table' => 'tx_finder_domain_model_finder',
				'MM_opposite_field' => 'related_from',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 100,
				'MM' => 'tx_finder_domain_model_finder_related_mm',
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
			)
		),
		'related_from' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_finder_domain_model_finder.related_from',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'foreign_table' => 'tx_finder_domain_model_finder',
				'allowed' => 'tx_finder_domain_model_finder',
				'size' => 5,
				'maxitems' => 100,
				'MM' => 'tx_finder_domain_model_finder_related_mm',
				'readOnly' => 1,
			)
		),
		'related_files' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.related_files',
			'config' => array(
				'type' => 'inline',
				'allowed' => 'tx_finder_domain_model_file',
				'foreign_table' => 'tx_finder_domain_model_file',
				'foreign_sortby' => 'sorting',
				'foreign_field' => 'parent',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'bottom',
					'useSortable' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showRemovedLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'showSynchronizationLink' => 1,
					'enabledControls' => array(
						'info' => FALSE,
					)
				)
			)
		),
		'related_links' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.related_links',
			'config' => array(
				'type' => 'inline',
				'allowed' => 'tx_finder_domain_model_link',
				'foreign_table' => 'tx_finder_domain_model_link',
				'foreign_sortby' => 'sorting',
				'foreign_field' => 'parent',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 10,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'bottom',
					'useSortable' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showRemovedLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'showSynchronizationLink' => 1,
					'enabledControls' => array(
						'info' => FALSE,
					)
				)
			)
		),
		'type' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.doktype_formlabel',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array($ll . 'tx_finder_domain_model_finder.type.I.0', 0),
					array($ll . 'tx_finder_domain_model_finder.type.I.1', 1),
					array($ll . 'tx_finder_domain_model_finder.type.I.2', 2),
				),
				'size' => 1,
				'maxitems' => 1,
			)
		),
		'keywords' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $TCA['pages']['columns']['keywords']['label'],
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 5,
			)
		),
		'media' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_finder_domain_model_finder.media',

			'config' => array(
				'type' => 'inline',
				'foreign_sortby' => 'sorting',
				'foreign_table' => 'tx_finder_domain_model_media',
				'foreign_field' => 'parent',
				'size' => 5,
				'minitems' => 0,
				'maxitems' => 99,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'bottom',
					'useSortable' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showRemovedLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'showSynchronizationLink' => 1,
					'enabledControls' => array(
						'info' => FALSE,
					)
				)
			)
		),
		'internalurl' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.palettes.links',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'db',
				'allowed' => 'pages',
				'size' => 1,
				'maxitems' => 1,
				'minitems' => 1,
				'show_thumbs' => 1,
				'wizards' => array(
					'suggest' => array(
						'type' => 'suggest',
					),
				),
			)
		),
		'externalurl' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:cms/locallang_tca.xml:pages.doktype.I.8',
			'config' => array(
				'type' => 'input',
				'size' => 50,
				'eval' => 'required'
			)
		),
		'istopfinder' => array(
			'exclude' => 1,
			'label' => $ll . 'tx_finder_domain_model_finder.istopfinder',
			'config' => array(
				'type' => 'check',
				'default' => 0
			)
		),
		'content_elements' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_finder.content_elements',
			'config' => array(
				'type' => 'inline',
				'allowed' => 'tt_content',
				'foreign_table' => 'tt_content',
				'MM' => 'tx_finder_domain_model_finder_ttcontent_mm',
				'minitems' => 0,
				'maxitems' => 99,
				'appearance' => array(
					'collapseAll' => 1,
					'expandSingle' => 1,
					'levelLinksPosition' => 'bottom',
					'useSortable' => 1,
					'showPossibleLocalizationRecords' => 1,
					'showRemovedLocalizationRecords' => 1,
					'showAllLocalizationLink' => 1,
					'showSynchronizationLink' => 1,
					'enabledControls' => array(
						'info' => FALSE,
					)
				)
			)
		),
		'path_segment' => array(
			'exclude' => 0,
			'label' => $ll . 'tx_finder_domain_model_finder.path_segment',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'nospace,alphanum_x,lower,unique',
			)
		),
		'import_id' => array(
			'label' => $ll . 'tx_finder_domain_model_finder.import_id',
			'config' => array(
				'type' => 'passthrough'
			)
		),

		'import_source' => array(
			'label' => $ll . 'tx_finder_domain_model_finder.import_source',
			'config' => array(
				'type' => 'passthrough'
			)
		)
	),
	'types' => array(
		// default finder
		'0' => array(
			'showitem' => 'l10n_parent, l10n_diffsource,
					title;;paletteCore,;;;;2-2-2,;;;;3-3-3,datetime;;paletteAlternative,
					bodytext;;;richtext::rte_transform[flag=rte_disabled|mode=ts_css],
					rte_disabled;LLL:EXT:cms/locallang_ttc.xml:rte_enabled_formlabel,
					content_elements,

				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;paletteAccess,

				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,categories,keywords,
				--div--;' . $ll . 'tx_finder_domain_model_finder.tabs.relations,media,related_files,related_links,related,related_from,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,'
		),
		// internal url
		'1' => array(
			'showitem' => 'l10n_parent, l10n_diffsource,
					title;;paletteCore,;;;;2-2-2,;;;;3-3-3,datetime;;paletteAlternative,internalurl,

				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;paletteAccess,

				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,categories,keywords,
				--div--;' . $ll . 'tx_finder_domain_model_finder.tabs.relations,media,related_files,related_links,related,related_from,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,'
		),
		// external url
		'2' => array(
			'showitem' => 'l10n_parent, l10n_diffsource,
					title;;paletteCore,;;;;2-2-2,;;;;3-3-3,datetime;;paletteAlternative,externalurl,

				--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,
					--palette--;LLL:EXT:cms/locallang_ttc.xml:palette.access;paletteAccess,

				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.options,categories,keywords,
				--div--;' . $ll . 'tx_finder_domain_model_finder.tabs.relations,media,related_files,related_links,related,related_from,
				--div--;LLL:EXT:cms/locallang_tca.xml:pages.tabs.extended,'
		),
	),
	'palettes' => array(
		'paletteCore' => array(
			'showitem' => 'istopfinder, type, sys_language_uid, hidden,',
			'canNotCollapse' => FALSE
		),
		'paletteAlternative' => array(
			'showitem' => 'alternative_title, path_segment,',
			'canNotCollapse' => FALSE
		),
		'paletteAccess' => array(
			'showitem' => 'starttime;LLL:EXT:cms/locallang_ttc.xml:starttime_formlabel,
					endtime;LLL:EXT:cms/locallang_ttc.xml:endtime_formlabel,',
			'canNotCollapse' => TRUE,
		),
	)
);

// category restriction based on settings in extension manager
$categoryRestrictionSetting = $configuration->getCategoryRestriction();
if ($categoryRestrictionSetting) {
	$categoryRestriction = '';
	switch ($categoryRestrictionSetting) {
		case 'current_pid':
			$categoryRestriction = ' AND tx_finder_domain_model_category.pid=###CURRENT_PID### ';
			break;
		case 'storage_pid':
			$categoryRestriction = ' AND tx_finder_domain_model_category.pid=###STORAGE_PID### ';
			break;
		case 'siteroot':
			$categoryRestriction = ' AND tx_finder_domain_model_category.pid IN (###SITEROOT###) ';
			break;
		case 'page_tsconfig':
			$categoryRestriction = ' AND tx_finder_domain_model_category.pid IN (###PAGE_TSCONFIG_IDLIST###) ';
			break;
		default:
			$categoryRestriction = '';
	}

	// prepend category restriction at the beginning of foreign_table_where
	if (!empty ($categoryRestriction)) {
		$TCA['tx_finder_domain_model_finder']['columns']['categories']['config']['foreign_table_where'] = $categoryRestriction .
			$TCA['tx_finder_domain_model_finder']['columns']['categories']['config']['foreign_table_where'];
	}
}

if (!$configuration->getContentElementRelation()) {
	unset($TCA['tx_finder_domain_model_finder']['columns']['content_elements']);
}

?>