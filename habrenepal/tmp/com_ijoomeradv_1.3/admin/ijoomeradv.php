<?php
/*--------------------------------------------------------------------------------
# com_ijoomeradv_1.3 - iJoomer Advanced
# ------------------------------------------------------------------------
# author Tailored Solutions - ijoomer.com
# copyright Copyright (C) 2010 Tailored Solutions. All rights reserved.
# license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
# Websites: http://www.ijoomer.com
# Technical Support: Forum - http://www.ijoomer.com/Forum/
----------------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

define('IJADV_VERSION',1.3);

jimport ( 'joomla.version' );
$version = new JVersion ( );

//define joomla version
defined ( 'IJ_JOOMLA_VERSION' ) or define ( 'IJ_JOOMLA_VERSION', floatval ( $version->RELEASE ) );

defined ( 'IJ_ADMIN' )			or define ( 'IJ_ADMIN', JPATH_COMPONENT );
defined ( 'IJ_SITE' )			or define ( 'IJ_SITE', JPATH_ROOT . DS . 'components' . DS . 'com_ijoomeradv' );
defined ( 'IJ_ASSET' )			or define ( 'IJ_ASSET', IJ_ADMIN . DS . 'assets' );
defined ( 'IJ_CONTROLLER' ) 	or define ( 'IJ_CONTROLLER', IJ_ADMIN . DS . 'controllers' );
defined ( 'IJ_HELPER' )			or define ( 'IJ_HELPER', IJ_ADMIN . DS . 'helpers' );
defined ( 'IJ_MODEL' )			or define ( 'IJ_MODEL', IJ_ADMIN . DS . 'models' );
defined ( 'IJ_TABLE' )			or define ( 'IJ_TABLE', IJ_ADMIN . DS . 'tables' );
defined ( 'IJ_VIEW' )			or define ( 'IJ_VIEW', IJ_ADMIN . DS . 'views' );

require_once (IJ_HELPER.DS.'helper.php');

$document = JFactory::getDocument ();
$document->addStyleSheet('components'.DS.'com_ijoomeradv'.DS.'assets'.DS.'css'.DS.'ijoomeradv.css' );

$controller = JRequest::getVar ('view','ijoomeradv');
$path = IJ_CONTROLLER . DS . $controller . '.php';
if (file_exists ( $path )) {
	require_once ($path);
} else {
	$classname = '';
}

$classname = 'ijoomeradvController' . $controller;
$controller = new $classname();

// Perform the Request task
$task=JRequest::getVar('task');
$controller->execute ($task);

// Redirect if set by the controller
$controller->redirect();
