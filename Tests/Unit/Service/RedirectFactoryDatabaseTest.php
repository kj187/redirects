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
 * Test case for class Tx_Requests_Service_RedirectFactory.
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
class Tx_Requests_Servic_RedirectFactoryDatabaseTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

	/**
	 * @var Tx_Redirects_Service_RedirectFactory
	 */
	protected $redirectFactory;

	/**
	 * @var Tx_Redirects_Domain_Model_Request
	 */
	protected $request;

	/**
	 * @var Tx_Redirects_Service_DeviceDetection
	 */
	protected $deviceDetection;

	/**
	 * @var Tx_Phpunit_Framework
	 */
	protected $testingFramework;

	public function setUp() {
		$this->redirectFactory = new Tx_Redirects_Service_RedirectFactory();
		$this->request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('dummy'), array(), '', FALSE);
		$this->deviceDetection = $this->getMock('Tx_Redirects_Service_DeviceDetection', array('getPossibleDevices'));
		$this->testingFramework = new Tx_Phpunit_Framework('tx_redirects');
		$this->testingFramework->createFakeFrontEnd();
	}

	public function tearDown() {
		$this->testingFramework->cleanUp();
		$this->testingFramework->discardFakeFrontEnd();
		unset($this->redirectFactory, $this->testingFramework);
	}

	/**
	 * @test
	 * @expectedException Tx_Redirects_Service_Exception_NoRedirectFound
	 * @return void
	 */
	public function throwsException() {
		$redirectFactory = new Tx_Redirects_Domain_Repository_RedirectRepository();
		$this->redirectFactory->injectRedirectRepository($redirectFactory);
		$this->redirectFactory->create($this->request, $this->deviceDetection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function foundRedirect() {
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first testing',
			'target' => 'http://www.aoemedia.de/',
			'header' => 301,
		));

		$redirectFactory = new Tx_Redirects_Domain_Repository_RedirectRepository();

		$this->deviceDetection->expects($this->any())->method('getPossibleDevices')->will($this->returnValue(array(1,2,3,4,5,6)));
		$this->redirectFactory->injectRedirectRepository($redirectFactory);
		$redirect = $this->redirectFactory->create($this->request, $this->deviceDetection);

		$this->assertSame(
			'first testing',
			$redirect->getTitle()
		);
	}

	/**
	 * Priority has the redirect with configured device.
	 *
	 * @test
	 * @return void
	 */
	public function foundRedirectByDevice() {
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first testing device',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'device' => 1,
		));
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'second testing',
			'target' => 'http://www.aoemedia.de/',
			'header' => 302,
		));
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first testing device',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'device' => 2,
		));

		$this->request->expects($this->any())->method('isApple')->will($this->returnValue(TRUE));

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.2'));
		$this->deviceDetection->expects($this->any())->method('getPossibleDevices')->will($this->returnValue(array(2)));

		$redirectFactory = new Tx_Redirects_Domain_Repository_RedirectRepository();
		$this->redirectFactory->injectRedirectRepository($redirectFactory);
		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);

		$this->assertSame(
			'first testing device',
			$redirect->getTitle()
		);
	}


	/**
	 * Priority has the redirect with configured device.
	 *
	 * @test
	 * @return void
	 */
	public function foundRedirectByDeviceAndExcludeIp() {
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first testing device',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'device' => 1,
		));
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'second testing',
			'target' => 'http://www.aoemedia.de/',
			'header' => 302,
		));
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first testing device',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'device' => 2,
			'exclude_ips' => '127.0.0.2',
		));

		$this->request->expects($this->any())->method('isApple')->will($this->returnValue(TRUE));

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.2'));
		$this->deviceDetection->expects($this->any())->method('getPossibleDevices')->will($this->returnValue(array(2)));

		$redirectFactory = new Tx_Redirects_Domain_Repository_RedirectRepository();
		$this->redirectFactory->injectRedirectRepository($redirectFactory);
		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);

		$this->assertSame(
			'second testing',
			$redirect->getTitle()
		);
	}

	/**
	 * @test
	 * @return void
	 */
	public function findRedirectOutOfManyRelatedRedirects() {
		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'first',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'exclude_ips' => '127.0.0.1,127.0.0.2',
		));

		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'second',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 301,
			'device' => 3,
		));

		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'third',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 303,
			'device' => 2,
		));

		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'fourth',
			'target' => 'http://www.aoemedia.de/userAgent',
			'header' => 303,
			'country_code' => 'GB',
			'accept_language' => 'EN',
			'device' => 2,
		));

		$this->testingFramework->createRecord('tx_redirects_domain_model_redirect', array(
			'title' => 'fifth',
			'target' => 'http://www.aoemedia.de/someOther',
			'header' => 301,
			'country_code' => 'GB',
			'accept_language' => 'DE',
			'device' => 2,
		));

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress', 'isApple', 'getAcceptLanguage', 'getCountryCode'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.2'));
		$request->expects($this->any())->method('getAcceptLanguage')->will($this->returnValue('EN'));
		$request->expects($this->any())->method('getCountryCode')->will($this->returnValue('GB'));

		$this->deviceDetection->expects($this->any())->method('getPossibleDevices')->will($this->returnValue(array(2)));

		$redirectFactory = new Tx_Redirects_Domain_Repository_RedirectRepository();
		$this->redirectFactory->injectRedirectRepository($redirectFactory);

		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);

		$this->assertSame(
			'fourth',
			$redirect->getTitle()
		);
	}
}
?>