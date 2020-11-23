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
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modTwitterFollowerbox {

function getTwitterFollowerbox( $params)   {
$twitter_username = $params->get('twitter_username');
$twitter_widget_id = $params->get('twitter_widget_id');
$widget_theme = $params->get('widget_theme');
$scrollber	= 'noscrollbar ';
$nofooter	= 'nofooter ';
$noborders	= 'noborders ';
$width = 246;
$height = 280;
	if (trim( $params->get( 'loadjQuery' ) ) == 1)

	{

	?> <script src="http://code.jquery.com/jquery-latest.js"></script>

	<?php

	}

	?>
<style type="text/css">
#on {
  visibility: visible;
}
#off {
  visibility: hidden;
}
#facebook_div {
  width: 196px;
  height: 340px;
  overflow: hidden;
}
#twitter_div {
  width: 276px;
  height: 280px;
  overflow: hidden;
}
#NBT_div {
  width: 300px;
  height: 97px;
  overflow: hidden;
}
/* right side style */
#twitter_right {
  z-index: 10004;
  border: 2px solid #6CC5FF;
  background-color: #6CC5FF;
  width: 246px;
  height: 280px;
  position: fixed;
  right: -250px;
}
#twitter_right_img {
  position: absolute;
  top: -2px;
  left: -35px;
  border: 0;
}
#NBT_right {
  z-index: 10003;
  border: 2px solid #303030;
  background-color: #fff;
  width: 300px;
  height: 97px;
  position: fixed;
}
#NBT_right img {
  position: absolute;
  top: -2px;
  left: -101px;
}
/* left side style */
#twitter_left {
  z-index: 10004;
  border: 2px solid #6CC5FF;
  background-color: #6CC5FF;
  width: 246px;
  height: 280px;
  position: fixed;
  left: -250px;
}
#twitter_left_img {
  position: absolute;
  top: -2px;
  right: -35px;
  border: 0;
}

</style>
<script type="text/javascript">

jQuery(document).ready(function () {
  jQuery("#twitter_right").hover(function () {
    jQuery(this).stop(true, false).animate({
      right: 0
    }, 500);
  }, function () {
    jQuery("#twitter_right").stop(true, false).animate({
      right: -250
    }, 500);
  });
  
});</script>

<div id="twitter_right" style="top: <?php echo $params->get( 'twitter_top' ); ?>%;">
 <div id="twitter_div">
		<img id="twitter_right_img" src="<?php echo JURI::root();?>modules/mod_twitterslider/twitter_right.png" />
	
		<div id="twitterfanbox">
<?php echo '<a class="twitter-timeline" data-theme="'.$widget_theme.'" data-chrome="'.$nofooter.$noborders.$scrollber.'"   href="https://twitter.com/'.$twitter_username.'" data-widget-id="'.$twitter_widget_id.'" width="'.$width.'" height="'.$height.'">Tweets by @'.$twitter_username.'</a>

<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
		
		?>
		</div>
		
	</div>
	
</div>
	<?php

	}

}?>