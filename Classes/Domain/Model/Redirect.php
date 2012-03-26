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
class Tx_Redirects_Domain_Model_Redirect extends Tx_Extbase_DomainObject_AbstractValueObject {

	/**
	 * Internal title
	 *
	 * @var string
	 * @validate NotEmpty
	 */
	protected $title;

	/**
	 * Select a domain to redirect.
	 *
	 * @var string
	 */
	protected $sourceDomain = '';

	/**
	 * URL path
	 *
	 * @var string
	 */
	protected $sourcePath;

	/**
	 * Force HTTPS
	 *
	 * @var boolean
	 */
	protected $forceSsl = FALSE;

	/**
	 * Keep Url parameter
	 *
	 * @var boolean
	 */
	protected $keepGet = FALSE;

	/**
	 * Target URL can be absolute or relative.
	 *
	 * @var string
	 */
	protected $target;

	/**
	 * HTTP header to send with the redirect.
	 *
	 * @var integer
	 */
	protected $header = 0;

	/**
	 * List of excluded IP adresses
	 *
	 * @var string
	 */
	protected $excludeIps;

	/**
	 * If a client comes from the selected country (requires maxmind apache module)
	 *
	 * @var string
	 */
	protected $countryCode = '';

	/**
	 * If a client accepts the selected language.
	 *
	 * @var integer
	 */
	protected $acceptLanguage = 0;

	/**
	 * If client is of lelected device type
	 *
	 * @var integer
	 */
	protected $device = 0;

	/**
	 * Redirect count
	 *
	 * @var string
	 */
	protected $count = 0;

	/**
	 * Disable redirect counter
	 *
	 * @var boolean
	 */
	protected $disableCount = FALSE;

	/**
	 * @var array
	 */
	protected $parameters = array();

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the sourceDomain
	 *
	 * @return integer $sourceDomain
	 */
	public function getSourceDomain() {
		return $this->sourceDomain;
	}

	/**
	 * Sets the sourceDomain
	 *
	 * @param integer $sourceDomain
	 * @return void
	 */
	public function setSourceDomain($sourceDomain) {
		$this->sourceDomain = $sourceDomain;
	}

	/**
	 * Returns the sourcePath
	 *
	 * @return string $sourcePath
	 */
	public function getSourcePath() {
		return $this->sourcePath;
	}

	/**
	 * Sets the sourcePath
	 *
	 * @param string $sourcePath
	 * @return void
	 */
	public function setSourcePath($sourcePath) {
		$this->sourcePath = $sourcePath;
	}

	/**
	 * Returns the forceSsl
	 *
	 * @return boolean $forceSsl
	 */
	public function getForceSsl() {
		return $this->forceSsl;
	}

	/**
	 * Sets the forceSsl
	 *
	 * @param boolean $forceSsl
	 * @return void
	 */
	public function setForceSsl($forceSsl) {
		$this->forceSsl = $forceSsl;
	}

	/**
	 * Returns the boolean state of forceSsl
	 *
	 * @return boolean
	 */
	public function isForceSsl() {
		return $this->getForceSsl();
	}

	/**
	 * Returns the keepGet
	 *
	 * @return boolean $keepGet
	 */
	public function getKeepGet() {
		return $this->keepGet;
	}

	/**
	 * Sets the keepGet
	 *
	 * @param boolean $keepGet
	 * @return void
	 */
	public function setKeepGet($keepGet) {
		$this->keepGet = $keepGet;
	}

	/**
	 * Returns the boolean state of keepGet
	 *
	 * @return boolean
	 */
	public function isKeepGet() {
		return $this->getKeepGet();
	}

	/**
	 * Returns the target
	 *
	 * @return string $target
	 */
	public function getTarget() {
		//TODO Add support for typoLink url generation based on given page id

		if (strpos($this->target, 'http') !== 0) {
			$this->target = t3lib_div::locationHeaderUrl($this->target);
		}

		if ($this->forceSsl === TRUE) {
			$this->target = str_replace('http://','https://', $this->target);
		}

		if ($this->keepGet === TRUE) {
			$parameterString = t3lib_div::implodeArrayForUrl('', $this->parameters);

			if (strlen($parameterString) > 0) {
				if(preg_match('/\?[^=]*?=[^&]*?/i', $this->target)) {
					$this->target .= $parameterString;
				} else {
					$this->target .= '?'.substr($parameterString, 1);
				}
			}
		}

		return $this->target;
	}

	/**
	 * Sets the target
	 *
	 * @param string $target
	 * @return void
	 */
	public function setTarget($target) {
		$this->target = $target;
	}

	/**
	 * Returns the header
	 *
	 * @return integer $header
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Sets the header
	 *
	 * @param integer $header
	 * @return void
	 */
	public function setHeader($header) {
		$this->header = $header;
	}

	/**
	 * Returns the excludeIps
	 *
	 * @return array $excludeIps
	 */
	public function getExcludeIps() {
		return t3lib_div::trimExplode(PHP_EOL, $this->excludeIps, TRUE);
	}

	/**
	 * Sets the excludeIps
	 *
	 * @param string $excludeIps
	 * @return void
	 */
	public function setExcludeIps($excludeIps) {
		$this->excludeIps = $excludeIps;
	}

	/**
	 * Returns the countryCode
	 *
	 * @return string $countryCode
	 */
	public function getCountryCode() {
		return $this->countryCode;
	}

	/**
	 * Sets the countryCode
	 *
	 * @param string $countryCode
	 * @return void
	 */
	public function setCountryCode($countryCode) {
		$this->countryCode = $countryCode;
	}

	/**
	 * Returns the acceptLanguage
	 *
	 * @return integer $acceptLanguage
	 */
	public function getAcceptLanguage() {
		return $this->acceptLanguage;
	}

	/**
	 * Sets the acceptLanguage
	 *
	 * @param integer $acceptLanguage
	 * @return void
	 */
	public function setAcceptLanguage($acceptLanguage) {
		$this->acceptLanguage = $acceptLanguage;
	}

	/**
	 * Returns the userAgent
	 *
	 * @return integer $userAgent
	 */
	public function getDevice() {
		return $this->device;
	}

	/**
	 * Sets the userAgent
	 *
	 * @param integer $userAgent
	 * @return void
	 */
	public function setDevice($userAgent) {
		$this->device = $userAgent;
	}

	/**
	 * Returns the count
	 *
	 * @return string $count
	 */
	public function getCount() {
		return $this->count;
	}

	/**
	 * Sets the count
	 *
	 * @param string $count
	 * @return void
	 */
	public function setCount($count) {
		$this->count = $count;
	}

	/**
	 * Returns the disableCount
	 *
	 * @return boolean $disableCount
	 */
	public function getDisableCount() {
		return $this->disableCount;
	}

	/**
	 * Sets the disableCount
	 *
	 * @param boolean $disableCount
	 * @return void
	 */
	public function setDisableCount($disableCount) {
		$this->disableCount = $disableCount;
	}

	/**
	 * Returns the boolean state of disableCount
	 *
	 * @return boolean
	 */
	public function isDisableCount() {
		return $this->getDisableCount();
	}

	/**
	 * @param array $parameters
	 * @return void
	 */
	public function setParameters(array $parameters) {
		$this->parameters = $parameters;
	}

	/**
	 * Retrun the prirority value for the current redirect object.
	 *
	 * @return integer
	 */
	public function getPriority() {
		$priority = 0;

		if ($this->device > 0) {
			$priority += 4;
		}

		if ($this->acceptLanguage != '') {
			$priority += 3;
		}

		if ($this->countryCode != '') {
			$priority += 5;
		}

		return $priority;
	}
}
?>