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
 *
 * @package redirects
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Redirects_Domain_Model_Request {

	/**
	 * Only available if apache module maxmind is installed.
	 *
	 * @var string
	 * @link http://www.maxmind.com/app/country
	 */
	protected $countryCode;

	/**
	 * @var string
	 */
	protected $acceptLanguage;

	/**
	 * @var string
	 */
	protected $remoteAddress;

	/**
	 * @var string
	 */
	protected $userAgent;

	/**
	 * @var string
	 */
	protected $domain;

	/**
	 * @var string
	 */
	protected $path;

	/**
	 * Initialize Request arguments to
	 */
	public function __construct() {
		$this->setDomain(t3lib_div::getIndpEnv('HTTP_HOST'));
		$this->setPath(t3lib_div::getIndpEnv('REQUEST_URI'));
		$this->setAcceptLanguage(t3lib_div::getIndpEnv('HTTP_ACCEPT_LANGUAGE'));
		$this->setCountryCode(apache_note('GEOIP_COUNTRY_CODE'));
		$this->setRemoteAddress(t3lib_div::getIndpEnv('REMOTE_ADDR'));
		$this->setUserAgent(t3lib_div::getIndpEnv('HTTP_USER_AGENT'));
	}

	/**
	 * @param string $domain
	 */
	public function setDomain($domain) {
		$this->domain = $domain;
	}

	/**
	 * Returns the domain
	 *
	 * @return string
	 */
	public function getDomain() {
		return $this->domain;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path) {
		$tmp = explode('?', $path, 2);
			// return only the path without any parameter
		$this->path = $tmp[0];
	}

	/**
	 * Returns the path without parameter
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * @param string $acceptLanguage
	 */
	public function setAcceptLanguage($acceptLanguage) {
		$this->acceptLanguage = $acceptLanguage;
	}

	/**
	 * @return string
	 */
	public function getAcceptLanguage() {
		return $this->acceptLanguage;
	}

	/**
	 * @param string $countryCode
	 */
	public function setCountryCode($countryCode) {
		$this->countryCode = $countryCode;
	}

	/**
	 * @return string
	 */
	public function getCountryCode() {
		return $this->countryCode;
	}

	/**
	 * @param string $remoteAddress
	 */
	public function setRemoteAddress($remoteAddress) {
		$this->remoteAddress = $remoteAddress;
	}

	/**
	 * @return string
	 */
	public function getRemoteAddress() {
		return $this->remoteAddress;
	}

	/**
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent) {
		$this->userAgent = $userAgent;
	}

	/**
	 * @return string
	 */
	public function getUserAgent() {
		return $this->userAgent;
	}
}
?>