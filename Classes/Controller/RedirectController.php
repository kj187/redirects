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
	 * redirectRepository
	 *
	 * @var Tx_Redirects_Domain_Repository_RedirectRepository
	 */
	protected $redirectRepository;

	/**
	 * @var Tx_Redirects_Domain_Model_Request
	 */
	protected $requestModel;

	/**
	 * injectRedirectRepository
	 *
	 * @param Tx_Redirects_Domain_Repository_RedirectRepository $redirectRepository
	 * @return void
	 */
	public function injectRedirectRepository(Tx_Redirects_Domain_Repository_RedirectRepository $redirectRepository) {
		$this->redirectRepository = $redirectRepository;
	}

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
	 * action redirect
	 *
	 * @return void
	 */
	public function indexAction() {
		error_log(__METHOD__, 0);
		$redirects = $this->redirectRepository->findAllByRequest($this->requestModel);

		foreach ($redirects as $redirect) {
			error_log('redirect-title: ' . $redirect->getTitle(), 0);
			$this->redirectRepository->incrementCounter($redirect);
		}
		error_log('redirect-title: ' . count($redirects), 0); exit();
	}

}
?>