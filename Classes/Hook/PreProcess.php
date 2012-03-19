<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Michael Klapper <michael.klapper@aoemedia.de>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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

		$bootstrap->run('', $config);
	}
}
