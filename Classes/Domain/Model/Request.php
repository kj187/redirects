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
class Tx_Redirects_Domain_Model_Request {

	/**
	 * Returns the domain
	 *
	 * @return string
	 */
	public function getDomain() {
		return t3lib_div::getIndpEnv('HTTP_HOST');
	}

	/**
	 * Returns the path without parameter
	 *
	 * @return string
	 */
	public function getPath() {
		$currentPath = t3lib_div::getIndpEnv('REQUEST_URI');
		$tmp = explode('?', $currentPath, 2);
			// return only the path without any parameter
		return $tmp[0];
	}

}
?>