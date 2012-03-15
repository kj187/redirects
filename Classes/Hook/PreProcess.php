<?php

tslib_eidtools::connectDB();
tslib_eidtools::initExtensionTca('redirects');

/**
 * Hook to process possible redirects.
 *
 * @author: Michael Klapper <michael.klapper@aoemedia.de>
 * @date: 14.03.12
 * @time: 14:25
 */
class Tx_Redirects_Hook_PreProcess {

	/**
	 * @var int
	 */
	protected $storagePid = 0;

	/**
	 * Initialize extension configuration.
	 *
	 * @return \Tx_Redirects_Hook_PreProcess
	 */
	public function __construct() {
		$extConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['redirects']);

		if (is_array($extConf) && array_key_exists('storagePid', $extConf)) {
			$this->storagePid = $extConf['storagePid'];
		}
	}

	/**
	 * Check for possible redirect action.
	 *
	 * @access public
	 * @return void
	 */
	public function process() {

		$config = array(
			'persistence'   => array(
				'storagePid' => $this->storagePid,
			),
			'userFunc'      => 'tx_extbase_core_bootstrap->run',
			'pluginName'    => 'Pi1',
			'extensionName' => 'Redirects',
			'settings'      => 	''
		);

		$GLOBALS['TSFE'] = t3lib_div::makeInstance('tslib_fe', $GLOBALS['TYPO3_CONF_VARS'], t3lib_div::_GP('id'), t3lib_div::_GP('type'), true);
		$GLOBALS['TSFE']->sys_page = t3lib_div::makeInstance('t3lib_pageSelect');

		require_once t3lib_extMgm::extPath('extbase') . 'Classes/Core/Bootstrap.php';
		$cObj            = t3lib_div::makeInstance('tslib_cObj');
		$bootstrap       = t3lib_div::makeInstance('Tx_Extbase_Core_Bootstrap');
		$bootstrap->cObj = $cObj;

		$response = $bootstrap->run('', $config);
	}
}
