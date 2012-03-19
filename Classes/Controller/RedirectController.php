<?php

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2012 Michael Klapper <development@morphodo.com>
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

/**
 *
 * @author Michael Klapper <development@morphodo.com>
 * @package redirects
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Tx_Redirects_Controller_RedirectController extends Tx_Extbase_MVC_Controller_ActionController {

	/**
	 * @var Tx_Redirects_Domain_Model_Request
	 */
	protected $requestModel;

	/**
	 * @var Tx_Redirects_Service_RedirectFactory
	 */
	protected $redirectFactory;

	/**
	 * @var Tx_Redirects_Service_DeviceDetection
	 */
	protected $deviceDetection;

	/**
	 * injectRedirectRepository
	 *
	 * @param Tx_Redirects_Domain_Model_Request $requestModel
	 * @return void
	 */
	public function injectRequest(Tx_Redirects_Domain_Model_Request $requestModel) {
		$this->requestModel = $requestModel;
	}

	/**
	 * @param Tx_Redirects_Service_RedirectFactory $redirectFactory
	 * @return void
	 */
	public function injectRedirectFactory(Tx_Redirects_Service_RedirectFactory $redirectFactory) {
		$this->redirectFactory = $redirectFactory;
	}

	/**
	 * @param Tx_Redirects_Service_DeviceDetection $deviceDetection
	 * @return void
	 */
	public function injectDeviceDetection(Tx_Redirects_Service_DeviceDetection $deviceDetection) {
		$this->deviceDetection = $deviceDetection;
	}

	/**
	 * action redirect
	 *
	 * @return void
	 */
	public function indexAction() {
		try {
			$redirect = $this->redirectFactory->create($this->requestModel, $this->deviceDetection);
			var_dump("header('Location: " . $redirect->getTarget() . "', TRUE, " . $redirect->getHeader() . ");");
		} catch (Exception $e) {
			error_log(__METHOD__ . ' - ' . $e->getMessage(), 0);
		}

		 exit();
	}
}
?>