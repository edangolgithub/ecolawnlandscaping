
<?php
/*------------------------------------------------------------------------
# mod_susnet_likebox 
# ------------------------------------------------------------------------
# author Susnet
# copyright Copyright (C) 2012 http://www.susnet.co.uk. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.susnet.co.uk/
# Technical Support: http://www.susnet.co.uk/extensions/item/susnet-like-box-joomla-module.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$document = &JFactory::getDocument();
$document->addStyleSheet( JURI::base() . 'modules/mod_susnet_likebox/css/style.css' );



require JModuleHelper::getLayoutPath('mod_susnet_likebox', $params->get('layout', 'default'));
