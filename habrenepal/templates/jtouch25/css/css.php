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

if( isset($debug) && ($debug == 1) ):
	require_once 'config.css.php';
	
	foreach ($loadCssFiles as $file):?>
		<link rel="stylesheet" href="<?php echo $thisTplUrl;?>/css/<?php echo $file ?>?ver=<?php echo $tplVer;?>" type="text/css" />
	<?php endforeach;
	
else: ?>
	<link rel="stylesheet" href="<?php echo $thisTplUrl;?>/css/template.css.php?ver=<?php echo $tplVer;?>&debug=<?php echo $debug;?>&jstruc=<?php echo $jStructure;?>" type="text/css" />
<?php endif;