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

defined ('_JEXEC') or die('Restricted access');

// Load jQuery lib or not
if ( isset($jJqueryLoad) && $jJqueryLoad == 1 ): ?>
<script src="<?php echo $thisTplUrl;?>/js/jquery-1.9.1.min.js?ver=<?php echo $tplVer;?>" type="text/javascript"></script>
<?php
endif;

// Combine js files (or not)
if( isset($debug) && $debug == 1 ):
	require_once 'config.js.php';
	
	foreach ($loadJsFiles as $file): ?>
		<script src="<?php echo $thisTplUrl;?>/js/<?php echo $file ?>?ver=<?php echo $tplVer;?>" type="text/javascript"></script>
	<?php endforeach;
	
else: ?>
<script src="<?php echo $thisTplUrl;?>/js/template.js.php?ver=<?php echo $tplVer;?>&debug=<?php echo $debug;?>&jquery=<?php echo $jJqueryLoad;?>" type="text/javascript"></script>
<?php endif; ?>
<script src="<?php echo $thisTplUrl;?>/js/jquery.validate.min.js?ver=<?php echo $tplVer;?>" type="text/javascript"></script>

<?php
// underscore and backbone.js
?>
<script src="<?php echo $thisTplUrl;?>/js/underscore-1.4.4.min.js?ver=<?php echo $tplVer;?>"  data-main="js/mobile"></script>
<?php 
	//ref: http://coenraets.org/backbone/jquerymobile/#
?>
<script src="<?php echo $thisTplUrl;?>/js/backbone-0.9.10.min.js?ver=<?php echo $tplVer;?>"  data-main="js/mobile"></script>
<script src="<?php echo $thisTplUrl;?>/js/router.js?ver=<?php echo $tplVer;?>"  data-main="js/mobile"></script>
