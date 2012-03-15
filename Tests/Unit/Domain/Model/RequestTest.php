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
}
?>