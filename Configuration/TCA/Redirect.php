<?php
if (!defined ('TYPO3_MODE')) {
	die ('Access denied.');
}

$TCA['tx_redirects_domain_model_redirect'] = array(
	'ctrl' => $TCA['tx_redirects_domain_model_redirect']['ctrl'],
	'interface' => array(
		'showRecordFieldList' => 'hidden, title, source_domain, source_path, force_ssl, keep_get, target, header, exclude_ips, country_code, accept_language, user_agent, count, disable_count',
	),
	'types' => array(
		'1' => array('showitem' => 'title, source_domain;;2, target;;3, header,--div--;LLL:EXT:redirects/Resources/Private/Language/locallang_db.xlf:tabs.client, country_code, accept_language, user_agent,--div--;LLL:EXT:redirects/Resources/Private/Language/locallang_db.xlf:tabs.redirectCount,count, disable_count,--div--;LLL:EXT:redirects/Resources/Private/Language/locallang_db.xlf:tabs.excludeIP, exclude_ips,--div--;LLL:EXT:cms/locallang_ttc.xml:tabs.access,hidden;;1'),
	),
	'palettes' => array(
		'1' => array('showitem' => 'starttime, endtime', 'canNotCollapse' => 1),
		'2' => array('showitem' => 'source_path', 'canNotCollapse' => 1),
		'3' => array('showitem' => 'force_ssl, keep_get', 'canNotCollapse' => 1),
	),
	'columns' => array(
		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'source_domain' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.source_domain',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'source_path' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.source_path',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'force_ssl' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.force_ssl',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'keep_get' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.keep_get',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
		'target' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.target',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'header' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.header',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'exclude_ips' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.exclude_ips',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'country_code' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.country_code',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'accept_language' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.accept_language',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'user_agent' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.user_agent',
			'config' => array(
				'type' => 'select',
				'items' => array(
					array('-- Label --', 0),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'count' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.count',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'disable_count' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect.disable_count',
			'config' => array(
				'type' => 'check',
				'default' => 0
			),
		),
	),
);

?>