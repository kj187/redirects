<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Redirect Management');

			t3lib_extMgm::addLLrefForTCAdescr('tx_redirects_domain_model_redirect', 'EXT:redirects/Resources/Private/Language/locallang_csh_tx_redirects_domain_model_redirect.xml');
			t3lib_extMgm::allowTableOnStandardPages('tx_redirects_domain_model_redirect');
			$TCA['tx_redirects_domain_model_redirect'] = array(
				'ctrl' => array(
					'title'	=> 'LLL:EXT:redirects/Resources/Private/Language/locallang_db.xml:tx_redirects_domain_model_redirect',
					'label' => 'title',
					'tstamp' => 'tstamp',
					'crdate' => 'crdate',
					'cruser_id' => 'cruser_id',
					'dividers2tabs' => TRUE,
					'versioningWS' => 2,
					'versioning_followPages' => TRUE,
					'origUid' => 't3_origuid',
					'languageField' => 'sys_language_uid',
					'transOrigPointerField' => 'l10n_parent',
					'transOrigDiffSourceField' => 'l10n_diffsource',
					'delete' => 'deleted',
					'enablecolumns' => array(
						'disabled' => 'hidden',
						'starttime' => 'starttime',
						'endtime' => 'endtime',
					),
					'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Redirect.php',
					'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_redirects_domain_model_redirect.gif'
				),
			);

?>