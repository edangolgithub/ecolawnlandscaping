<?php
/*------------------------------------------------------------------------
# mod_twitterslider - Twitter Slider Module
# ------------------------------------------------------------------------
# @author - Twitter Slider
# copyright Copyright (C) 2013 TwitterSlider.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://twitterslider.com/
# Technical Support:  Forum - http://twitterslider.com/index.php/forum
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( dirname(__FILE__).DS.'helper.php' );
$twitterfollowerbox = modTwitterFollowerbox::getTwitterFollowerbox( $params);
require( JModuleHelper::getLayoutPath( 'mod_twitterslider' ) );
?>