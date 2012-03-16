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
 * DeviceDetection Class
 *
 * @author: Michael Klapper <development@morphodo.com>
 * @date: 15.03.12
 * @time: 11:21
 */
class Tx_Redirects_Service_RedirectFactory {

	/**
	 * redirectRepository
	 *
	 * @var Tx_Redirects_Domain_Repository_RedirectRepository
	 */
	protected $redirectRepository;

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
	 * @var Tx_Extbase_Persistence_QueryResult<Tx_Redirects_Domain_Model_Redirect>
	 */
	protected $redirects;

	/**
	 * @var Tx_Redirects_Domain_Model_Request
	 */
	protected $request;

	/**
	 * @param Tx_Redirects_Domain_Model_Request $request
	 * @param Tx_Redirects_Service_DeviceDetection $deviceDetection
	 * @return Tx_Redirects_Domain_Model_Redirect
	 */
	public function buildHttpRedirect(Tx_Redirects_Domain_Model_Request $request, Tx_Redirects_Service_DeviceDetection $deviceDetection) {
		$redirects = $this->redirectRepository->findAllByRequest($request);
		$deviceDetection->setUserAgent($request->getUserAgent());

		foreach ($redirects as $redirect) { /** @var $redirect Tx_Redirects_Domain_Model_Redirect */

			if ($redirect->getKeepGet() === TRUE) {
				$redirect->addParameters($request->getParameters());
			}

			if ($redirect->getDisableCount() === FALSE) {
				$this->redirectRepository->incrementCounter($redirect);
			}
		}

		if (!$redirect instanceof Tx_Redirects_Domain_Model_Redirect) {
			throw new Exception('No redirect available.');
		}

		return $redirect;
	}
}
