
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
<?php if ($params->get('jquery')=="1") : ?>
<script src="modules/mod_susnet_likebox/js/jquery-1.7.2.js"></script>
<?php endif; ?>
<script type="text/javascript">jQuery.noConflict();</script>


<div class="scroll"></div>
        <div id="jslikeboxsidebar<?php echo $params->get('jsleftright'); ?>" style="top: <?php echo $params->get('positiontop'); ?>px;">
			
            <div class="jslikeboxsidebarinner"><div class="jslikeboxsidebarbutton<?php echo $params->get('jsleftright'); ?>">
			
			
			<div id="likebox<?php echo $params->get('jsbutton'); ?><?php echo $params->get('jsleftright'); ?>" style="width: 326px; padding: 7px;">

			
			 <div id="likebox-frame-<?php echo $params->get('boxstyle'); ?><?php echo $params->get('boxcorners'); ?>" style="width: 288px; overflow: hidden;">
		<!--[if IE]>
			 <iframe style="width: 293px; height: <?php echo ($params->get('connections') + $params->get('facebookstream')); ?>px; margin: -1px -4px 0 -4px;" frameborder="0" border="0" src="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get('facebookid'); ?>&width=300&colorscheme=<?php echo $params->get('boxstyle'); ?>&connections=50&stream=<?php if ($params->get('facebookstream')) : ?>true<?php else : ?>false<?php endif; ?>&header=false&height=820" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
<![endif]-->

<!--[if !IE]>-->
    <object type="text/html" style="width: 293px; height: <?php echo ($params->get('connections') + $params->get('facebookstream')); ?>px; margin: -1px -4px 0 -4px;" data="http://www.facebook.com/plugins/likebox.php?href=<?php echo $params->get('facebookid'); ?>&width=300&colorscheme=<?php echo $params->get('boxstyle'); ?>&connections=50&stream=<?php if ($params->get('facebookstream')) : ?>true<?php else : ?>false<?php endif; ?>&header=false&height=820" ></object>
<!--<![endif]-->

		</div>	
		
	</div></div></div>

	<?php 
$app = JFactory::getApplication(); 
$menu = $app->getMenu(); 
if ($menu->getActive() == $menu->getDefault()) { 
    echo '<div class="ssupport"><a href="http://www.susnet.co.uk/" title="Web Design">Web Design</a></div>
        '; 
} 
?>

</div>

        <script type="text/javascript">

             jQuery(document).ready(function($) {


                $('#jslikeboxsidebarleft > div').hover(
                    function () {
                        $('.jslikeboxsidebarbuttonleft',$(this)).stop().animate({'marginLeft':'-12px'},<?php echo $params->get('openspeed'); ?>);
                    },
                    function () {
                        $('.jslikeboxsidebarbuttonleft',$(this)).stop().animate({'marginLeft':'-305px'},<?php echo $params->get('closespeed'); ?>);
                    }
                );
       
		
                $('#jslikeboxsidebarright > div').hover(
                    function () {
                        $('.jslikeboxsidebarbuttonright',$(this)).stop().animate({'marginLeft':'-290px'},<?php echo $params->get('openspeed'); ?>);
                    },
                    function () {
                        $('.jslikeboxsidebarbuttonright',$(this)).stop().animate({'marginLeft':'8px'},<?php echo $params->get('closespeed'); ?>);
                    }
                );
            });
			
</script>