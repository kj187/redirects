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
 * Test case for class Tx_Redirects_Controller_RedirectController.
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
class Tx_Redirects_Controller_RedirectControllerTest extends Tx_Extbase_Tests_Unit_BaseTestCase {
	/**
	 * @var Tx_Redirects_Controller_RedirectController
	 */
	protected $redirectController;

	public function setUp() {
		$this->redirectController = new Tx_Redirects_Controller_RedirectController();
	}

	public function tearDown() {
		unset($this->fixture);
	}

	/**
	 * @test
	 */
	public function indexActionCallsRedirectFactory() {
        $this->markTestIncomplete();
        $redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
        $redirectFixture->setTitle('first');
        $redirectFixture->setTarget('http://www.aoemedia.de/userAgent');
        $redirectFixture->setHeader(301);

        $redirectFactory = $this->getMock('Tx_Redirects_Service_RedirectFactory', array('create'));
        $redirectFactory->expects($this->once())->method('create')->will($this->returnValue($redirectFixture));

        $request = $this->getMock('Tx_Redirects_Domain_Model_Request');
        $deviceDetection = $this->getMock('Tx_Redirects_Service_DeviceDetection');

        $this->redirectController->injectRedirectFactory($redirectFactory);
        $this->redirectController->injectRequest($request);
        $this->redirectController->injectDeviceDetection($deviceDetection);
        $this->redirectController->indexAction();
        $headerList = xdebug_get_headers();
        $this->assertContains('Location: http://www.aoemedia.de/userAgent', $headerList);

    }

}
?>