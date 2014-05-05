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
 * Simple status report for the reports module
 *
 * @author: Michael Klapper <michael.klapper@aoemedia.de>
 * @date: 14.03.12
 * @time: 14:25
 */
class Tx_Redirects_Utility_RedirectsRequirementsCheck implements \TYPO3\CMS\Reports\StatusProviderInterface {
	/**
	 * Compiles a collection of system status checks as a status report.
	 *
	 * @see typo3/sysext/reports/interfaces/tx_reports_StatusProvider::getStatus()
	 */
	public function getStatus() {
		$reports = array(
			'apacheMaxMindIsAvailable' => $this->getGeoIpValueForCurrentClient(),
			'apacheGetEnvIsAvailable' => $this->checkIfApacheGetEnvIsAvailable(),
		);

		return $reports;
	}

	/**
	 * Check whether dbal extension is installed
	 *
	 * @return tx_reports_reports_status_Status
	 */
	public function getGeoIpValueForCurrentClient() {
		if (function_exists('apache_getenv')) {
			$countryCode = apache_getenv('GEOIP_COUNTRY_CODE');
			if ($countryCode != '') {
				$value = 'Country Detected';
				$message = 'Your detected country code is "' . $countryCode . '"';
				$status = \TYPO3\CMS\Reports\Status::OK;
			} else {
				$value = 'Country could not detected.';
				$message = 'Please be sure that the maxmind apache module is loaded correctly.';
				$status = \TYPO3\CMS\Reports\Status::INFO;
			}
		}

		return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('tx_reports_reports_status_Status',
			'Apache maxmind',
			$value,
			$message,
			$status
		);
	}

	/**
	 * Check whether dbal extension is installed
	 *
	 * @return tx_reports_reports_status_Status
	 */
	protected function checkIfApacheGetEnvIsAvailable() {

		if (function_exists('apache_getenv')) {
			$value = 'Available';
			$message = '';
			$status = \TYPO3\CMS\Reports\Status::OK;
		} else {
			$value = 'Function not available!';
			$message = 'The function is required to fetch the country code from Apaches environment variable "GEOIP_COUNTRY_CODE"';
			$status = \TYPO3\CMS\Reports\Status::ERROR;
		}

		return t3lib_div::makeInstance('tx_reports_reports_status_Status',
			'PHP Function "apache_getenv"',
			$value,
			$message,
			$status
		);
	}
}
