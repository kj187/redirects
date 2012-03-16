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
 *
 *
 * @package redirects
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class Tx_Redirects_Domain_Repository_RedirectRepository extends Tx_Extbase_Persistence_Repository {

	/**
	 * Fetch all redirect records based on given $domain and $path property.
	 *
	 * @param string $domain
	 * @param string $path
	 * @return array
	 */
	public function findAllByDomainAndPath($domain, $path) {
		$query = $this->createQuery();
		$query->getQuerySettings()->getRespectEnableFields(TRUE);
		$query->getQuerySettings()->getRespectSysLanguage(FALSE);
		$originalPath    = $path;
		$alternativePath = rtrim('/', $path);


		return $query->statement('
		SELECT *, IF(tx_redirects_domain_model_redirect.source_domain = "0",1,0) AS masked
		FROM tx_redirects_domain_model_redirect
		WHERE
				(tx_redirects_domain_model_redirect.source_domain = "0" OR tx_redirects_domain_model_redirect.source_domain = (SELECT uid FROM sys_domain WHERE domainName = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($domain) . ') )
			AND
				(tx_redirects_domain_model_redirect.source_path = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($originalPath) . ' OR tx_redirects_domain_model_redirect.source_path = ' . $GLOBALS['TYPO3_DB']->fullQuoteStr($alternativePath) . ' )
			AND hidden = 0 AND deleted = 0 ORDER BY masked ASC,force_ssl DESC LIMIT 5')->execute();
	}
}
?>