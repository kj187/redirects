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
class Tx_Requests_Servic_RedirectFactoryTest extends Tx_Extbase_Tests_Unit_BaseTestCase {

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

	public function setUp() {
		$this->redirectFactory = new Tx_Redirects_Service_RedirectFactory();
		$this->request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('dummy'), array(), '', FALSE);
		$this->deviceDetection = $this->getMock('Tx_Redirects_Service_DeviceDetection', array('dummy'));
	}

	public function tearDown() {
		unset($this->redirectFactory);
	}

	/**
	 * @test
	 * @expectedException Tx_Redirects_Service_Exception_NoRedirectFound
	 * @return void
	 */
	public function throwsException() {
		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array()));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);
		$this->redirectFactory->create($this->request, $this->deviceDetection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function foundRedirect() {
		$redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture->setTarget('http://www.aoemedia.de/');
		$redirectFixture->setHeader(301);

		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array($redirectFixture)));
		$this->deviceDetection->expects($this->any())->method('getPossibleDevices')->will($this->returnValue(array(1,2,3,4,5,6)));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);
		$redirect = $this->redirectFactory->create($this->request, $this->deviceDetection);

		$this->assertSame(
			$redirectFixture,
			$redirect
		);
	}

	/**
	 * Priority has the redirect with configured device.
	 *
	 * @test
	 * @return void
	 */
	public function foundRedirectByDevice() {
		$redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture->setHeader(301);
		$redirectFixture->setDevice(2);

		$redirectFixture2 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture2->setTarget('http://www.aoemedia.de/');
		$redirectFixture2->setHeader(302);

		$this->request->expects($this->any())->method('isApple')->will($this->returnValue(TRUE));

		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array($redirectFixture, $redirectFixture2)));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);
		$redirect = $this->redirectFactory->create($this->request, $this->deviceDetection);

		$this->assertSame(
			$redirectFixture,
			$redirect
		);
	}

	/**
	 * @test
	 * @return void
	 * @expectedException Tx_Redirects_Service_Exception_NoRedirectFound
	 */
	public function excludeRedirectByRemoteAddressThrowsException() {
		$redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture->setHeader(301);
		$redirectFixture->setDevice(2);
		$redirectFixture->setExcludeIps('127.0.0.1,127.0.0.2');

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.2'));

		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array($redirectFixture)));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);

		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);
	}

	/**
	 * @test
	 * @return void
	 */
	public function excludeRedirectByRemoteAddress() {
		$redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture->setHeader(301);
		$redirectFixture->setDevice(2);
		$redirectFixture->setExcludeIps('127.0.0.1,127.0.0.2');

		$redirectFixture2 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture2->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture2->setHeader(301);
		$redirectFixture2->setDevice(3);

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.2'));

		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array($redirectFixture, $redirectFixture2)));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);

		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);

		$this->assertSame(
			$redirectFixture2,
			$redirect
		);
	}


	/**
	 * @test
	 * @return void
	 */
	public function findRedirectOutOfManyRelatedRedirects() {
		$redirectFixture = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture->setTitle('first');
		$redirectFixture->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture->setHeader(301);
		$redirectFixture->setExcludeIps('127.0.0.1,127.0.0.2');

		$redirectFixture2 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture2->setTitle('second');
		$redirectFixture2->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture2->setHeader(301);
		$redirectFixture2->setDevice(3);

		$redirectFixture3 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture3->setTitle('third');
		$redirectFixture3->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture3->setHeader(303);
		$redirectFixture3->setDevice(2);

		$redirectFixture4 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture4->setTitle('fourth');
		$redirectFixture4->setTarget('http://www.aoemedia.de/userAgent');
		$redirectFixture4->setHeader(303);
		$redirectFixture4->setCountryCode('GB');
		$redirectFixture4->setAcceptLanguage('EN');
		$redirectFixture4->setDevice(2);

		$redirectFixture5 = new Tx_Redirects_Domain_Model_Redirect();
		$redirectFixture5->setTitle('fifth');
		$redirectFixture5->setTarget('http://www.aoemedia.de/someOther');
		$redirectFixture5->setHeader(301);
		$redirectFixture5->setCountryCode('GB');
		$redirectFixture5->setAcceptLanguage('EN');
		$redirectFixture5->setDevice(2);

		$request = $this->getMock('Tx_Redirects_Domain_Model_Request', array('getRemoteAddress', 'isApple', 'getAcceptLanguage', 'getCountryCode'), array(), '', FALSE);
		$request->expects($this->any())->method('getRemoteAddress')->will($this->returnValue('127.0.0.3'));

		$redirectRepository = $this->getMock('Tx_Redirects_Domain_Repository_RedirectRepository');
		$redirectRepository->expects($this->any())->method('findAllByRequest')->will($this->returnValue(array($redirectFixture, $redirectFixture2, $redirectFixture3, $redirectFixture4, $redirectFixture5)));
		$this->redirectFactory->injectRedirectRepository($redirectRepository);

		$redirect = $this->redirectFactory->create($request, $this->deviceDetection);

		$this->assertSame(
			$redirectFixture4,
			$redirect
		);
	}
}
?>