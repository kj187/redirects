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

/**
 * RedirectFactory Class
 *
 * @author: Michael Klapper <michael.klapper@aoemedia.de>
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
	 * Build the redirect object out of the request and device given as argument.
	 *
	 * @param Tx_Redirects_Domain_Model_Request $request
	 * @param Tx_Redirects_Service_DeviceDetection $deviceDetection
	 * @throws Tx_Redirects_Service_Exception_NoRedirectFound
	 * @return Tx_Redirects_Domain_Model_Redirect
	 */
	public function create(Tx_Redirects_Domain_Model_Request $request, Tx_Redirects_Service_DeviceDetection $deviceDetection) {
		$deviceDetection->setUserAgent($request->getUserAgent());
		$redirectMatch = null; /** @var $redirectMatch Tx_Redirects_Domain_Model_Redirect */
		$redirects     = $this->redirectRepository->findAllByRequest($request, $deviceDetection->getPossibleDevices());

		foreach ($redirects as $redirect) { /** @var $redirect Tx_Redirects_Domain_Model_Redirect */

				// check for matching exclude IP
			if (in_array($request->getRemoteAddress(), $redirect->getExcludeIps())) {
				continue;
			}

			if (!$redirectMatch instanceof Tx_Redirects_Domain_Model_Redirect || $redirect->getPriority() > $redirectMatch->getPriority()) {
				$redirectMatch = $redirect;
			}
		}

		if (!$redirectMatch instanceof Tx_Redirects_Domain_Model_Redirect) {
			throw new Tx_Redirects_Service_Exception_NoRedirectFound('No redirect available for request: ' . $request);
		}

		if ($redirectMatch->getKeepGet() === TRUE) {
			$redirectMatch->setParameters($request->getParameters());
		}

		if ($redirectMatch->getDisableCount() === FALSE) {
			$this->redirectRepository->incrementCounter($redirectMatch);
		}

		return $redirectMatch;
	}
}
