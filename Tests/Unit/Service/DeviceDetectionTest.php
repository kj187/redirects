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
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class Tx_Requests_Service_DeviceDetection.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Redirect Management
 *
 * @author Michael Klapper <development@morphodo.com>
 */
class Tx_Requests_Servic_DeviceDetectionTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Redirects_Service_DeviceDetection
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Redirects_Service_DeviceDetection();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @return mixed
	 */
	public function androidDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (Linux; U; Android 2.3.3; de-de; HTC Desire Build/GRI40) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'),
			array('Mozilla/5.0 (Linux; U; Android 1.6; ar-us; SonyEricssonX10i Build/R2BA026) AppleWebKit/528.5+ (KHTML, like Gecko) Version/3.1.2 Mobile Safari/525.20.1'),
			array('Mozilla/5.0 (Linux; U; Android 2.3; en-us) AppleWebKit/999+ (KHTML, like Gecko) Safari/999.9'),
		);
	}

	/**
	 * @test
	 * @dataProvider androidDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function androidDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isAndroid());
	}

	/**
	 * @return mixed
	 */
	public function appleDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (iPad; U; CPU OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B334b Safari/531.21.10'),
			array('Mozilla/5.0(iPad; U; CPU iPhone OS 3_2 like Mac OS X; en-us) AppleWebKit/531.21.10 (KHTML, like Gecko) Version/4.0.4 Mobile/7B314 Safari/531.21.10'),
		);
	}

	/**
	 * @test
	 * @dataProvider appleDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function appleDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isApple());
	}

	/**
	 * @return mixed
	 */
	public function blackberryDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (BlackBerry; U; BlackBerry 9850; en-US) AppleWebKit/534.11+ (KHTML, like Gecko) Version/7.0.0.115 Mobile Safari/534.11+'),
			array('BlackBerry9800/5.0.0.862 Profile/MIDP-2.1 Configuration/CLDC-1.1 VendorID/331 UNTRUSTED/1.0 3gpp-gba'),
		);
	}

	/**
	 * @test
	 * @dataProvider blackberryDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function blackberryDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isBlackberry(), 'isBlackberry');
	}

	/**
	 * @return mixed
	 */
	public function desktopDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
			array('Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.0.1) Gecko/20020912'),
		);
	}

	/**
	 * @test
	 * @dataProvider desktopDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function desktopDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isDesktop(), 'isDesktop');
	}

	/**
	 * @return mixed
	 */
	public function kindleDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (Linux; U; en-US) AppleWebKit/528.5+ (KHTML, like Gecko, Safari/528.5+) Version/4.0 Kindle/3.0 (screen 600×800; rotate)'),
			array('Mozilla/5.0 (Linux; U; Android 2.3.4; en-us; Kindle Fire Build/GINGERBREAD) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1'),
		);
	}

	/**
	 * @test
	 * @dataProvider kindleDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function kindleDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isKindle(), 'isKindle');
	}

	/**
	 * @return mixed
	 */
	public function smartPhoneDeviceCouldBeDetectedDataProvider() {
		return array(
			array('')
		);
	}

	/**
	 * @test
	 * @dataProvider smartPhoneDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function smartPhoneDeviceCouldBeDetected($userAgentString) {
		$this->markTestIncomplete('This test has no test data defined.');
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isSmartPhone(), 'isSmartPhone');
	}

	/**
	 * @return mixed
	 */
	public function tabletDeviceCouldBeDetectedDataProvider() {
		return array(
			array('Mozilla/5.0 (Linux; U; Android 2.2; en-gb; SAMSUNG GT-P1000 Tablet Build/MASTER)'),
		);
	}

	/**
	 * @test
	 * @dataProvider tabletDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function tabletDeviceCouldBeDetected($userAgentString) {
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isTabled(), 'isTablet');
	}

	/**
	 * @return mixed
	 */
	public function touchDeviceCouldBeDetectedDataProvider() {
		return array(
			array('')
		);
	}

	/**
	 * @test
	 * @dataProvider touchDeviceCouldBeDetectedDataProvider
	 * @param striog $userAgentString
	 */
	public function touchDeviceCouldBeDetected($userAgentString) {
		$this->markTestIncomplete('This test has no test data defined.');
		$this->fixture->setUserAgent($userAgentString);

		$this->assertTrue($this->fixture->isTouch(), 'isTouch');
	}
}
?>