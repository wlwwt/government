<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

$ll = 'LLL:EXT:finder/Resources/Private/Language/locallang_db.xml:';


$TCA['tx_finder_domain_model_file'] = array(
	'ctrl' => $TCA['tx_finder_domain_model_file']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid,l10n_parent,l10n_diffsource,hidden,title,description,file'
	),
	'feInterface' => $TCA['tx_finder_domain_model_file']['feInterface'],
	'columns' => array(
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
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
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
		'title' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_file.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
			)
		),
		'description' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_file.description',
			'config' => array(
				'type' => 'text',
				'cols' => 30,
				'rows' => 5,
			)
		),
		'file' => array(
			'exclude' => 0,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => $ll . 'tx_finder_domain_model_file.file',
			'config' => array(
				'type' => 'group',
				'internal_type' => 'file',
				'allowed' => '',
				'disallowed' => 'php,php3',
				'max_size' => $GLOBALS['TYPO3_CONF_VARS']['BE']['maxFileSize'],
				'uploadfolder' => 'uploads/tx_finder',
				'show_thumbs' => 1,
				'size' => 1,
				'minitems' => 1,
				'maxitems' => 1,
			)
		),
	),
	'types' => array(
		0 => array(
			'showitem' => 'file;;paletteCore,title;;paletteDescription'
		)
	),
	'palettes' => array(
		'paletteCore' => array(
			'showitem' => 'hidden,sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource,',
			'canNotCollapse' => FALSE
		),
		'paletteDescription' => array(
			'showitem' => 'description',
			'canNotCollapse' => FALSE
		)
	)
);


?>