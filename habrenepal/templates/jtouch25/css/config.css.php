<?php 
/**
 * @package 	Jtouch25 Template
 * @copyright	Copyright (C) 2011 - 2012 JtouchMobile.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
defined ('_JEXEC') or die('Restricted access');

$loadCssFiles = array();

if( 	(isset($_REQUEST['jstruc']) && $_REQUEST['jstruc'] == 1) 
	|| 	(isset($jStructure) && $jStructure == 1) ){
	$loadCssFiles[] = 'jquery.mobile.structure-1.3.1.css';
}else{
	$loadCssFiles[] = 'jquery.mobile-1.3.1.css';
}
if( file_exists(dirname(__FILE__).'/jtouch-custom.css') ){
	$loadCssFiles[] = 'jtouch-custom.css';
}
$loadCssFiles[] = 'add2home.css';
$loadCssFiles[] = 'template.css';
