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
 * Test case for class Tx_Requests_Domain_Model_Request.
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
class Tx_Requests_Domain_Model_RequestTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Requests_Domain_Model_Request
	 */
	protected $fixture;

	public function setUp() {
		$this->fixture = new Tx_Redirects_Domain_Model_Request();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function setRemoteAddressForStringSetsRemoteAddress() {
		$this->fixture->setRemoteAddress('127.0.0.1');

		$this->assertSame(
			'127.0.0.1',
			$this->fixture->getRemoteAddress()
		);
	}

	/**
	 * @test
	 */
	public function setParametersForArraySetsParameters() {
		$this->fixture->setParmeters(array(
			'id' => 2,
			'day' => 'friday',
			'weather' => 'nice',
		));

			// expected that "id" are unseted
		$this->assertSame(
			array(
				'day' => 'friday',
				'weather' => 'nice',
			),
			$this->fixture->getParameters()
		);

			// expected that "id" and "parameterWithTooLongValue" are unseted
		$this->fixture->setParmeters(array(
			'id' => 2,
			'day' => 'friday',
			'weather' => 'nice',
			'parameterWithTooLongValue' => str_pad('', Tx_Redirects_Domain_Model_Request::MAX_PARAM_LENGTH + 1, "."),
		));

		$this->assertSame(
			array(
				'day' => 'friday',
				'weather' => 'nice',
			),
			$this->fixture->getParameters()
		);

			// expected that "id" and "parameterWithEmptyValue" are unseted
		$this->fixture->setParmeters(array(
			'id' => 2,
			'day' => 'friday',
			'weather' => 'nice',
			'parameterWithEmptyValue' => '',
		));

		$this->assertSame(
			array(
				'day' => 'friday',
				'weather' => 'nice',
			),
			$this->fixture->getParameters()
		);
	}

	/**
	 * @return array
	 */
	public function setAcceptedLanguageStringForAcceptedLanguageDataProvider() {
		return array(
			array('de-DE,de;q=0.8,en-US;q=0.9,en;q=0.4', 'DE'), // google chrome
			array('en-us,en;q=0.5', 'EN'), // Mozilla
			array('en-US,en;q=0.9', 'EN'), // Opera
			array('en-us', 'en'), // Internet Explorer
			array('en', 'EN'), // Lynx
			array('da, en-gb;q=0.8, en;q=0.7', 'EN'),
			array('en-US', 'EN'),
		);
	}

	/**
	 * @test
	 * @param string $clientLanguageString
	 * @param string $expectedLanguageDetected
	 * @dataProvider setAcceptedLanguageStringForAcceptedLanguageDataProvider
	 */
	public function setAcceptedLanguageStringForAcceptedLanguage($clientLanguageString, $expectedLanguageDetected) {
		$this->fixture->setAcceptLanguage($clientLanguageString);

		$this->assertEquals(
			$expectedLanguageDetected,
			$this->fixture->getAcceptLanguage()
		);
	}
}
?>