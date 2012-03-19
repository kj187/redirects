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
class Tx_Redirects_Service_DeviceDetection {

	/**
	 * @var integer
	 */
	const USER_AGENT_ANDROID = 1;

	/**
	 * @var integer
	 */
	const USER_AGENT_APPLE = 2;

	/**
	 * @var integer
	 */
	const USER_AGENT_BLACKBERRY = 3;

	/**
	 * @var integer
	 */
	const USER_AGENT_DESKTOP = 4;

	/**
	 * @var integer
	 */
	const USER_AGENT_SMARTPHONE = 5;

	/**
	 * @var integer
	 */
	const USER_AGENT_TABLET =  6;

	/**
	 * @var string
	 */
	protected $userAgent;

	/**
	 * @var boolean
	 */
	protected $isIPhone = FALSE;

	/**
	 * @var boolean
	 */
	protected $isIPod = FALSE;

	/**
	 * @var boolean
	 */
	protected $isIPad = FALSE;

	/**
	 * @var boolean
	 */
	protected $isBlackberry = FALSE;

	/**
	 * @var boolean
	 */
	protected $isPlayBook = FALSE;

	/**
	 * @var boolean
	 */
	protected $isAndroid = FALSE;

	/**
	 * @var boolean
	 */
	protected $isMacOS = FALSE;

	/**
	 * @var boolean
	 */
	protected $isWindows = FALSE;

	/**
	 * @var boolean
	 */
	protected $isMac = FALSE;

	/**
	 * @var boolean
	 */
	protected $isWPhone = FALSE;

	/**
	 * @var boolean
	 */
	protected $isMobile = FALSE;

	/**
	 * @var boolean
	 */
	protected $isAndroidTabled = FALSE;

	/**
	 * @var boolean
	 */
	protected $isTabled = FALSE;

	/**
	 * @var boolean
	 */
	protected $isPalmDevice = FALSE;

	/**
	 * @var boolean
	 */
	protected $isKindle = FALSE;

	/**
	 * @var boolean
	 */
	protected $isUnknownMobileDevice = FALSE;

	/**
	 * Find out if the current device is of type "touch".
	 *
	 * @return boolean
	 */
	public function isTouch() {
		return $this->isIPhone || $this->isIPod || $this->isIPad || $this->isAndroid;
	}

	/**
	 * Find out if the current device is an Apple product.
	 *
	 * @return boolean
	 */
	public function isApple() {
		return $this->isMac || $this->isMacOS || $this->isIPhone || $this->isIPod || $this->isIPad;
	}

	/**
	 * Find out if the current device is an Blackberry product.
	 *
	 * @return boolean
	 */
	public function isBlackberry() {
		return $this->isBlackberry;
	}

	/**
	 * Find out if the current device is an Android product.
	 *
	 * @return boolean
	 */
	public function isAndroid() {
		return $this->isAndroid || $this->isAndroidTabled;
	}

	/**
	 * Find out if the current device is of type "tabled"
	 *
	 * @return boolean
	 */
	public function isTablet() {
		return $this->isTabled || $this->isPlayBook || $this->isIPad || $this->isAndroidTabled;
	}

	/**
	 * Find out if the current device is an amazon Kindle product.
	 *
	 * @return boolean
	 */
	public function isKindle() {
		return $this->isKindle;
	}

	/**
	 * Find out if the current device is of type "desktop".
	 *
	 * @return boolean
	 */
	public function isDesktop() {
		return !$this->isTouch() && !$this->isTablet() && !$this->isSmartPhone();
	}

	/**
	 * Find out if the current device is of type "smart phone".
	 *
	 * @return boolean
	 */
	public function isSmartPhone() {
		return ($this->isMobile || $this->isBlackberry() || $this->isPalmDevice || $this->isUnknownMobileDevice) && !$this->isTablet() && !$this->isKindle();
	}

	/**
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent) {
		$this->userAgent = $userAgent;

		$this->isIPhone              =  FALSE !== strpos($this->userAgent, 'IPhone');
		$this->isIPod                =  FALSE !== strpos($this->userAgent, 'IPod');
		$this->isIPad                =  FALSE !== strpos($this->userAgent, 'IPad');
		$this->isBlackberry          =  FALSE !== strpos($this->userAgent, 'BlackBerry');
		$this->isPlayBook            =  FALSE !== strpos($this->userAgent, 'PlayBook');
		$this->isAndroid             =  FALSE !== strpos($this->userAgent, 'Android');
		$this->isMacOS               =  FALSE !== strpos($this->userAgent, 'Mac OS X');
		$this->isWindows             =  FALSE !== strpos($this->userAgent, 'Windows');
		$this->isMac                 =  FALSE !== strpos($this->userAgent, 'Macintosh');
		$this->isWPhone              = (FALSE !== strpos($this->userAgent, 'Windows Phone OS') || FALSE !== strpos($this->userAgent, 'Windows CE') || FALSE !== strpos($this->userAgent, 'Windows Mobile'));
		$this->isMobile              =  FALSE !== strpos($this->userAgent, 'Mobile');
		$this->isAndroidTabled       = (FALSE !== strpos($this->userAgent, 'GT-P1000') || FALSE !== strpos($this->userAgent, 'SGH-T849') || FALSE !== strpos($this->userAgent, 'SHW-M180S'));
		$this->isTabled              =  FALSE !== strpos($this->userAgent, 'Tablet PC');
		$this->isPalmDevice          = (FALSE !== strpos($this->userAgent, 'PalmOS') || FALSE !== strpos($this->userAgent, 'PalmSource') || FALSE !== strpos($this->userAgent, 'Pre/'));
		$this->isKindle              =  FALSE !== strpos($this->userAgent, 'Kindle');
		$this->isUnknownMobileDevice = (FALSE !== strpos($this->userAgent, 'Opera Mini') || FALSE !== strpos($this->userAgent, 'smartphone') || FALSE !== strpos($this->userAgent, 'SonyEricsson'));
	}

	/**
	 * Find all device matches for current client given by request object.
	 *
	 * @return array
	 */
	public function getPossibleDevices() {
		$matches = array();

		if ($this->isAndroid()) {
			$matches[] = self::USER_AGENT_ANDROID;
		}
		if ($this->isApple()) {
			$matches[] = self::USER_AGENT_APPLE;
		}
		if ($this->isBlackberry()) {
			$matches[] = self::USER_AGENT_BLACKBERRY;
		}
		if ($this->isDesktop()) {
			$matches[] = self::USER_AGENT_DESKTOP;
		}
		if ($this->isSmartPhone()) {
			$matches[] = self::USER_AGENT_SMARTPHONE;
		}
		if ($this->isTablet()) {
			$matches[] = self::USER_AGENT_TABLET;
		}

		return $matches;
	}
}
