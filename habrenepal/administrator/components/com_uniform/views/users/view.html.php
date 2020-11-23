<?php

/**
 * @version     $Id: view.html.php 19013 2012-11-28 04:48:47Z thailv $
 * @package     JSN_Mobilize
 * @subpackage  AdminComponent
 * @author      JoomlaShine Team <support@joomlashine.com>
 * @copyright   Copyright (C) 2012 JoomlaShine.com. All Rights Reserved.
 * @license     GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Websites: http://www.joomlashine.com
 * Technical Support:  Feedback - http://www.joomlashine.com/contact-us/get-support.html
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Mobilization view.
 *
 * @package     JSN_Mobilize
 * @subpackage  AdminComponent
 * @since       1.0.0
 */
class JSNUniformViewUsers extends JSNUsersView
{

		/**
		 * Method for display page.
		 *
		 * @param   boolean  $tpl  The name of the template file to parse; automatically searches through the template paths.
		 *
		 * @return  mixed  A string if successful, otherwise a JError object.
		 */
		public function display($tpl = null)
		{
				// Load assets
				JSNUniformHelper::addAssets();

				JSNHtmlAsset::addScript(JURI::root(true) . '/plugins/system/jsnframework/assets/3rd-party/jquery/jquery-1.8.2.js');
				JSNHtmlAsset::addScriptLibrary('jquery.ui', JURI::root(true) . '/plugins/system/jsnframework/assets/3rd-party/jquery-ui/js/jquery-ui-1.9.0.custom.min', array('jquery'));

				parent::display($tpl);

				echo JSNHtmlAsset::loadScript('uniform/emailuser', array(), true);
		}
}