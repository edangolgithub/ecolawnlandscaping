<?php
/**
 * @package 	Jtouch.Plugin
 * @author		Nguyen Mobile
 * @copyright	Copyright (C) 2011 - 2013 JTouchMobile.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

class plgsystemjtouchmobileInstallerScript
{
	/**
	 * Constructor
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 */
	public function __constructor(JAdapterInstance $adapter){
		
	}

	/**
	 * Called before any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/
	public function preflight($route, JAdapterInstance $adapter){
		return true;
	}

	/**
	 * Called after any type of action
	 *
	 * @param   string  $route  Which action is happening (install|uninstall|discover_install)
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/
	public function postflight($route, JAdapterInstance $adapter){
		echo "<div>postflight jobs:</div>";
		$config = JFactory::getConfig();
		
		// Create cache folder for mobile pages if not exist: /cache/jtouch25page
		$cacheBase = $config->get('cache_path', JPATH_CACHE);
		$cacheBase .= '/jtouch25page';
		if( ! is_dir($cacheBase) ){
			mkdir($cacheBase, 0775);
			echo "<br /> - $cacheBase does not exist. Created!";
		}else{
			echo "<br /> - $cacheBase is exist";
		}
		
		// Clear Jtouch cached script files: /cache/jtouch25
		$scriptCache = $config->get('cache_path', JPATH_CACHE);
		$scriptCache .= 'jtouch25';
		if( is_dir($scriptCache) ){
			jimport( 'joomla.application.component.model');
			JModel::addIncludePath (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_cache' . DS . 'models');
			$cacheModel =& JModel::getInstance('cache', 'cacheModel');
			$cacheModel->clean('jtouch25');
			echo "<br /> - $scriptCache was deleted!";
		}
		
		// Disable Sytem Cache plugin
		$query = "UPDATE #__extensions SET enabled=0 WHERE name='plg_system_cache' LIMIT 1 ";
		$db = JFactory::getDbo();
		$db->setQuery( $query );
		$db->query();
		echo "<br /> - System Cache plugin was disabled!";
		
		return true;
	}

	/**
	 * Called on installation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/
	public function install(JAdapterInstance $adapter){
		return true;
	}

	/**
	 * Called on update
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	 *
	 * @return  boolean  True on success
	*/
	public function update(JAdapterInstance $adapter){
		return true;
	}

	/**
	 * Called on uninstallation
	 *
	 * @param   JAdapterInstance  $adapter  The object responsible for running this script
	*/
	public function uninstall(JAdapterInstance $adapter){
		return true;
	}
}