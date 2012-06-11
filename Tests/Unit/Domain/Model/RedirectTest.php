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
 * Test case for class Tx_Redirects_Domain_Model_Redirect.
 *
 * @version $Id$
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @package TYPO3
 * @subpackage Redirect Management
 *
 * @author Michael Klapper <michael.klapper@aoemedia.de>
 */
class Tx_Redirects_Domain_Model_RedirectTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Redirects_Domain_Model_Redirect
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Redirects_Domain_Model_Redirect();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle() {
		$this->fixture->setTitle('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function getSourceDomainReturnsInitialValueForInteger() {

		$this->assertSame(
			'',
			$this->fixture->getSourceDomain()
		);
	}

	/**
	 * @test
	 */
	public function setSourceDomainForIntegerSetsSourceDomain() {
		$this->fixture->setSourceDomain(12);

		$this->assertSame(
			12,
			$this->fixture->getSourceDomain()
		);
	}

	/**
	 * @test
	 */
	public function getSourcePathReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setSourcePathForStringSetsSourcePath() {
		$this->fixture->setSourcePath('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getSourcePath()
		);
	}

	/**
	 * @test
	 */
	public function getForceSslReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->fixture->getForceSsl()
		);
	}

	/**
	 * @test
	 */
	public function setForceSslForBooleanSetsForceSsl() {
		$this->fixture->setForceSsl(TRUE);
		$this->fixture->setTarget('http://www.aoemedia.de/');

		$this->assertSame(
			TRUE,
			$this->fixture->getForceSsl()
		);

		$this->assertEquals(
			'https://www.aoemedia.de/',
			$this->fixture->getTarget()
		);
	}

	/**
	 * @test
	 */
	public function getKeepGetReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->fixture->getKeepGet()
		);
	}

	/**
	 * @test
	 */
	public function setKeepGetForBooleanSetsKeepGet() {
		$this->fixture->setKeepGet(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getKeepGet()
		);
	}

	/**
	 * @test
	 */
	public function getTargetReturnsInitialValueForString() { }

	/**
	 * @test
	 */
	public function setTargetForStringSetsTarget() {
		$this->fixture->setTarget('http://www.aoemedia.de');

		$this->assertSame(
			'http://www.aoemedia.de',
			$this->fixture->getTarget()
		);
	}

	/**
	 * @return array
	 */
	public function setTargetForStringAndParametersArraySetsTargetDataProvider() {
		return array(
			array('http://www.aoemedia.de', array(), 'http://www.aoemedia.de'),
			array('http://www.aoemedia.de', array('test' => 'value'), 'http://www.aoemedia.de?test=value'), // sems that the last "/" is not required :)
			array('http://www.aoemedia.de/', array('test' => 'value'), 'http://www.aoemedia.de/?test=value'),
			array('http://www.aoemedia.de/home/', array(), 'http://www.aoemedia.de/home/'),
			array('http://www.aoemedia.de/home/', array('test' => 'value'), 'http://www.aoemedia.de/home/?test=value'),
			array('http://www.aoemedia.de/home/?test=value', array('my' => 'value'), 'http://www.aoemedia.de/home/?test=value&my=value'),
			array('http://www.aoemedia.de/home/?test=value&hello=world', array('my' => 'value'), 'http://www.aoemedia.de/home/?test=value&hello=world&my=value'),
		);
	}

	/**
	 * @test
	 * @dataProvider setTargetForStringAndParametersArraySetsTargetDataProvider
	 * @param $target
	 * @param $parameters
	 * @param $expectedTarget
	 */
	public function setTargetForStringAndParametersArraySetsTarget($target, $parameters, $expectedTarget) {
		$this->fixture->setKeepGet(TRUE);
		$this->fixture->setTarget($target);
		$this->fixture->setParameters($parameters);

		$this->assertSame(
			$expectedTarget,
			$this->fixture->getTarget()
		);
	}

	/**
	 * @test
	 */
	public function getHeaderReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->fixture->getHeader()
		);
	}

	/**
	 * @test
	 */
	public function setHeaderForIntegerSetsHeader() {
		$this->fixture->setHeader(12);

		$this->assertSame(
			12,
			$this->fixture->getHeader()
		);
	}

	/**
	 * @test
	 */
	public function getExcludeIpsReturnsInitialValueForString() {
		$this->assertSame(
			array(),
			$this->fixture->getExcludeIps()
		);
	}

	/**
	 * @test
	 */
	public function setExcludeIpsForStringSetsExcludeIps() {
		$ipArray = array('127.0.0.1');
		$this->fixture->setExcludeIps('127.0.0.1');

		$this->assertSame(
			$ipArray,
			$this->fixture->getExcludeIps()
		);

		$ipArray = array('127.0.0.1', '127.0.0.2');
		$this->fixture->setExcludeIps('127.0.0.1' . PHP_EOL . '127.0.0.2');

		$this->assertSame(
			$ipArray,
			$this->fixture->getExcludeIps()
		);
	}

	/**
	 * @test
	 */
	public function getCountryCodeReturnsInitialValueForInteger() {
		$this->assertSame(
			'',
			$this->fixture->getCountryCode()
		);
	}

	/**
	 * @test
	 */
	public function setCountryCodeForIntegerSetsCountryCode() {
		$this->fixture->setCountryCode('DE');

		$this->assertSame(
			'DE',
			$this->fixture->getCountryCode()
		);
	}

	/**
	 * @test
	 */
	public function getAcceptLanguageReturnsInitialValueForInteger() {
		$this->assertSame(
			'',
			$this->fixture->getAcceptLanguage()
		);
	}

	/**
	 * @test
	 */
	public function setAcceptLanguageForIntegerSetsAcceptLanguage() {
		$this->fixture->setAcceptLanguage(12);

		$this->assertSame(
			12,
			$this->fixture->getAcceptLanguage()
		);
	}

	/**
	 * @test
	 */
	public function getUserAgentReturnsInitialValueForInteger() {
		$this->assertSame(
			0,
			$this->fixture->getDevice()
		);
	}

	/**
	 * @test
	 */
	public function setUserAgentForIntegerSetsUserAgent() {
		$this->fixture->setDevice(12);

		$this->assertSame(
			12,
			$this->fixture->getDevice()
		);
	}

	/**
	 * @test
	 */
	public function getCountReturnsInitialValueForString() {
		$this->assertSame(
			0,
			$this->fixture->getCount()
		);
	}

	/**
	 * @test
	 */
	public function setCountForStringSetsCount() {
		$this->fixture->setCount('Conceived at T3CON10');

		$this->assertSame(
			'Conceived at T3CON10',
			$this->fixture->getCount()
		);
	}

	/**
	 * @test
	 */
	public function getDisableCountReturnsInitialValueForBoolean() {
		$this->assertSame(
			FALSE,
			$this->fixture->getDisableCount()
		);
	}

	/**
	 * @test
	 */
	public function setDisableCountForBooleanSetsDisableCount() {
		$this->fixture->setDisableCount(TRUE);

		$this->assertSame(
			TRUE,
			$this->fixture->getDisableCount()
		);
	}

}
?>