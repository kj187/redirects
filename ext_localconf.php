<?php

Tx_Extbase_Utility_Extension::configurePlugin(
	'redirects',
	'Pi1',
	array(
		'Redirect' => 'index',
	),
		// non-cacheable actions
	array(
		'Redirect' => 'index',
	)
);

$extbaseObjectContainer = t3lib_div::makeInstance('Tx_Extbase_Object_Container_Container'); // Singleton
$extbaseObjectContainer->registerImplementation('Tx_Extbase_Configuration_ConfigurationManagerInterface', 'Tx_Redirects_Configuration_ConfigurationManager');

if (is_array($TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'])) {
	array_unshift($TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'],'EXT:redirects/Classes/Hook/PreProcess.php:&Tx_Redirects_Hook_PreProcess->process');
} else {
	$TYPO3_CONF_VARS['SC_OPTIONS']['tslib/index_ts.php']['preprocessRequest'] = array('EXT:redirects/Classes/Hook/PreProcess.php:&Tx_Redirects_Hook_PreProcess->process');
}