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
 *
 *
 * @package redirects
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Redirects_Domain_Model_Request {

	/**
	 * Max parameter value length
	 *
	 * @var integer
	 */
	const MAX_PARAM_LENGTH = 60;

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
	 * @var array
	 */
	protected $parameters = array();

	/**
	 * Initialize Request arguments to
	 */
	public function __construct() {
		$this->setDomain(t3lib_div::getIndpEnv('HTTP_HOST'));
		$this->setPath(t3lib_div::getIndpEnv('REQUEST_URI'));
		$this->setAcceptLanguage(t3lib_div::getIndpEnv('HTTP_ACCEPT_LANGUAGE'));
		if (function_exists('apache_getenv')) {
			$this->setCountryCode(apache_getenv('GEOIP_COUNTRY_CODE'));
		}
		$this->setRemoteAddress(t3lib_div::getIndpEnv('REMOTE_ADDR'));
		$this->setUserAgent(t3lib_div::getIndpEnv('HTTP_USER_AGENT'));
		$this->setParmeters(t3lib_div::_GET());
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

		if (isset($acceptLanguage) && strlen($acceptLanguage) > 1) {
			$matches = array();
			$lang = array();
			$languageStruct = t3lib_div::trimExplode(',', $acceptLanguage, TRUE);

			foreach ($languageStruct as $value) {
					// check for q-value and create associative array. No q-value means priority 10
				if(preg_match("/(.*);q=([0-1]{0,1}\.\d{0,4})/i", $value, $matches)) {
					$priority = (int)((float)$matches[2] * 10);
					$lang[$priority] = $matches[1];
				} else {
					$lang[10] = $value;
				}
			}
			ksort($lang);

			$this->acceptLanguage = strtoupper(substr(array_pop($lang), 0, 2));
		}
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

	/**
	 * @param array $parameters
	 * @return void
	 */
	public function setParmeters(array $parameters) {
		unset($parameters['id']);
		unset($parameters['type']);
		unset($parameters['no_cache']);
		unset($parameters['cHash']);
		unset($parameters['chash']);

		foreach ($parameters as $k => $v) {
			if ($parameters[$k] == '' || $parameters[$k] === 0 || strlen($parameters[$k]) > self::MAX_PARAM_LENGTH) {
				unset($parameters[$k]);
			}
		}

		$this->parameters = $parameters;
	}

	/**
	 * @return array
	 */
	public function getParameters() {
		return $this->parameters;
	}
}
?>