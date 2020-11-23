
<?php
/*------------------------------------------------------------------------
# mod_susnet_likebox 
# ------------------------------------------------------------------------
# author Susnet
# copyright Copyright (C) 2012 http://www.susnet.co.uk. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.susnet.co.uk/
# Technical Support:  http://www.susnet.co.uk/extensions/item/susnet-like-box-joomla-module.html
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 
?>

			<div id="likeboxstandard" style="width: <?php echo ($params->get('standardwidth') - 5); ?>px; height: <?php echo $params->get('standardheight'); ?>px; overflow: hidden;">


	<!--[if IE]>
			 <iframe style="width: <?php echo $params->get('standardwidth'); ?>px; height: <?php echo $params->get('standardheight'); ?>px; margin: -1px -4px 0 -4px;" frameborder="0" border="0" src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get('facebookid'); ?>&amp;width=<?php echo $params->get('standardwidth'); ?>&amp;colorscheme=<?php echo $params->get('boxstyle'); ?>&amp;connections=<?php echo $params->get('standardprofiles'); ?>&amp;stream=<?php if ($params->get('facebookstreamstandard')) : ?>true<?php else : ?>false<?php endif; ?>&amp;header=false&amp;height=820" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<![endif]-->

<!--[if !IE]>-->
    <object type="text/html" style="width: <?php echo $params->get('standardwidth'); ?>px; height:<?php echo $params->get('standardheight'); ?>px; margin: -1px -4px 0 -4px;" data="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get('facebookid'); ?>&amp;width=<?php echo $params->get('standardwidth'); ?>&amp;colorscheme=<?php echo $params->get('boxstyle'); ?>&amp;connections=<?php echo $params->get('standardprofiles'); ?>&amp;stream=<?php if ($params->get('facebookstreamstandard')) : ?>true<?php else : ?>false<?php endif; ?>&amp;header=false&amp;height=820" ></object>
<!--<![endif]-->


        </div>




       