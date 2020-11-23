<?php 
/**
 * @package 	Jtouch.Template
 * @author		Nguyen Mobile
 * @copyright	Copyright (C) 2011 - 2013 JTouchMobile.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('_JEXEC') or die;

function modChrome_onlyTitle($module, &$params, &$attribs) {
	$jqmTheme = isset($attribs['theme'])? $attribs['theme'] : '';
	?>
	<li id="li-page-nav-<?php echo $module->id;?>"><a href="#module-page-<?php echo $module->id;?>" id="title-page-nav-<?php echo $module->id;?>"><?php echo $module->title;?></a></li>
	<div data-role="page" id="page-module-<?php echo $module->id;?>" data-add-back-btn="true" data-theme="<?php echo $jqmTheme;?>">
		<div data-role="header" data-position="fixed">
			<h1><?php echo $module->title;?></h1>
		</div>
		<div data-role="content">
			CONTENT
		</div>
	</div>
	<?php
}


function modChrome_jqmPage($module, &$params, &$attribs) {
	$jqmTheme = isset($attribs['theme'])? $attribs['theme'] : 'd';
	?>
	<div data-role="page" id="page-module-<?php echo $module->id;?>" data-add-back-btn="true" data-theme="<?php echo $jqmTheme;?>">
		<div data-role="header" data-position="fixed">
			<h1 class="module-title" title="page-module-<?php echo $module->id;?>"><?php echo $module->title;?></h1>
		</div>
		<div data-role="content">
			<?php echo $module->content;?>
		</div>
	</div>
	
	<?php
}


function modChrome_jqmTabs($module, &$params, &$attribs) {
	$jqmTheme = isset($attribs['theme'])? $attribs['theme'] : 'd';
	 
	?>
	<div id="page-module-<?php echo $module->id;?>" class="tab-content">
		<h1 class="tab-module-title" title="page-module-<?php echo $module->id;?>"><?php echo $module->title;?></h1>
		<div><?php echo $module->content;?></div>
	</div>
	<?php
}


function modChrome_jqmNone($module, &$params, &$attribs) {
	echo $module->content;
}