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
 * Custom configuration manager for special usage in early requests.
 *
 * @author: Michael Klapper <michael.klapper@aoemedia.de>
 * @date: 14.03.12
 * @time: 15:45
 */
class Tx_Redirects_Configuration_ConfigurationManager extends Tx_Extbase_Configuration_ConfigurationManager {

	/**
	 * Returns the specified configuration.
	 * The actual configuration will be merged from different sources in a defined order.
	 *
	 * Note that this is a low level method and only makes sense to be used by Extbase internally.
	 *
	 * NOTE:
	 * - Verifies that the Framework settings always return a "Tx_Extbase_MVC_Web_FrontendRequestHandler"
	 *
	 * @param string $configurationType The kind of configuration to fetch - must be one of the CONFIGURATION_TYPE_* constants
	 * @param string $extensionName if specified, the configuration for the given extension will be returned.
	 * @param string $pluginName if specified, the configuration for the given plugin will be returned.
	 * @return array The configuration
	 */
	public function getConfiguration($configurationType, $extensionName = NULL, $pluginName = NULL) {
		switch ($configurationType) {
			case self::CONFIGURATION_TYPE_SETTINGS :
				$configuration = $this->concreteConfigurationManager->getConfiguration($extensionName, $pluginName);
				return $configuration['settings'];
			case self::CONFIGURATION_TYPE_FRAMEWORK :
				$settings = $this->concreteConfigurationManager->getConfiguration($extensionName, $pluginName);
				if (!is_array($settings['mvc']['requestHandlers']))
					$settings['mvc']['requestHandlers'] = array('Tx_Extbase_MVC_Web_FrontendRequestHandler' => 'Tx_Extbase_MVC_Web_FrontendRequestHandler');
				return $settings;
			case self::CONFIGURATION_TYPE_FULL_TYPOSCRIPT :
				return $this->concreteConfigurationManager->getTypoScriptSetup();
			default :
				throw new Tx_Extbase_Configuration_Exception_InvalidConfigurationType('Invalid configuration type "' . $configurationType . '"', 1206031879);
		}
	}
}
