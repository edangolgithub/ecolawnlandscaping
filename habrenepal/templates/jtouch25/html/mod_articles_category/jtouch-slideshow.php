<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$imgList = '';$imgCount = 0;
foreach($list as $item){
	$img = array();
	$images = json_decode($item->images);
	if( isset($images->image_intro) && strlen($images->image_intro) > 3 ){
		$img['url']  = htmlspecialchars($images->image_intro);
	} else {	
		$matches = array();
		preg_match('/src="([^"]*)"/i', $item->introtext, $matches);//'/(alt|title|src)=("[^"]*")/i
		if( isset($matches[1]) ){
			$img['url'] = $matches[1]; 
		}else{
			// Has no image in this article
			$img['url'] = JURI::base().'templates/jtouch25/banner.png';
		}
	}
	if(strpos($img['url'], 'http://') === false){
		$img['url'] = JURI::base().$img['url'];
	}
	$img['caption'] = addslashes($item->title);
	$img['link'] = $item->link;
	
	$imgList .= "{ url: '{$img['url']}', caption: '{$img['caption']}', link: '{$img['link']}' }, ";
	$imgCount++;
}

// prevent multi modules conflict
$uniqueID = $module->id;

$document = JFactory::getDocument();
// Photoswipe slideshow http://www.photoswipe.com/
$document->addStyleSheet(JURI::base().'templates/jtouch25/js/photoswipe/photoswipe.min.css', 'jtouch.cssfile');
$document->addScript(JURI::base().'templates/jtouch25/js/photoswipe/klass.min.js', 'jtouch.jsfile');
$document->addScript(JURI::base().'templates/jtouch25/js/photoswipe/code.photoswipe.jquery-3.0.4.min.js', 'jtouch.jsfile');

$script = <<<EOL
(function($){
$(document).ready(function() {
	var instance_#UNIQUE_SLIDE_ID#, indicators_#UNIQUE_SLIDE_ID#;
	instance_#UNIQUE_SLIDE_ID# = Code.PhotoSwipe.attach(
		[
			#IMAGES_ARRAY#
		],
		{
			autoStartSlideshow: true,
			captionAndToolbarAutoHideDelay: 0, // second to dispapper caption
			captionAndToolbarFlipPosition: true, // move the caption to bottom
			imageScaleMethod: 'fitNoUpscale', //"fit", "fitNoUpscale" or "zoom"
			//jQueryMobile: true,
			loop: false,
			slideshowDelay: 3000,
			slideSpeed: 250,
			swipeThreshold: 50,
			preventHide: true,
			target: window.document.querySelectorAll('#Ps_#UNIQUE_SLIDE_ID#')[0],
			getImageSource: function(obj){
				return obj.url;
			},
			getImageCaption: function(obj){
				return obj.caption;
			},
			getImageMetaData: function(obj){
				return {
					link: obj.link
				}
			}
		}
	);
	
	
	indicators_#UNIQUE_SLIDE_ID# = window.document.querySelectorAll('#Indicators_#UNIQUE_SLIDE_ID# span');
	
	// onDisplayImage - set the current indicator
	instance_#UNIQUE_SLIDE_ID#.addEventHandler(Code.PhotoSwipe.EventTypes.onDisplayImage, function(e){
		var i, len;
		for (i=0, len=indicators_#UNIQUE_SLIDE_ID#.length; i<len; i++){
			indicators_#UNIQUE_SLIDE_ID#[i].setAttribute('class', '');
		}
		indicators_#UNIQUE_SLIDE_ID#[e.index].setAttribute('class', 'current');
		
	});
	
		
	// onTap - open link
	instance_#UNIQUE_SLIDE_ID#.addEventHandler(Code.PhotoSwipe.EventTypes.onTouch, function(e){
		if (e.action === 'tap'){
			var currentImage = instance_#UNIQUE_SLIDE_ID#.getCurrentImage();
			//console.log(currentImage);
			window.open(currentImage.metaData.link, '_self');
		}
	});
	instance_#UNIQUE_SLIDE_ID#.show(0);
});
})(jQuery);
EOL;
$script = str_replace(array('#UNIQUE_SLIDE_ID#', '#IMAGES_ARRAY#'), array($uniqueID, $imgList), $script);

$css = <<< EOL
#Ps_#UNIQUE_SLIDE_ID# { width: 100%; height: 180px; }
#Indicators_#UNIQUE_SLIDE_ID# { text-align: center; margin-top: 5px; }
#Indicators_#UNIQUE_SLIDE_ID# span { display: inline-block; height: 10px; width: 10px; margin: 0 10px 0 0; padding: 0; -webkit-border-radius:5px; -moz-border-radius:5px; -o-border-radius:5px; border-radius:5px; background: #c5c5c5;}
#Indicators_#UNIQUE_SLIDE_ID# span.current{ background: #456F9A; }
.jtouch-gallery .ps-toolbar {display:none !important;}
.jtouch-gallery .ps-caption {display:block !important; opacity:0.8;}

EOL;
$css = str_replace('#UNIQUE_SLIDE_ID#', $uniqueID, $css);
$document->addScriptDeclaration($script, 'jtouch.jscode');
$document->addStyleDeclaration($css, 'jtouch.csscode');
?>

<div class="jtouch-gallery <?php echo $moduleclass_sfx;?>">
	<div id="Ps_<?php echo $uniqueID;?>"></div>
	<div id="Indicators_<?php echo $uniqueID;?>">
		<?php for($i=0; $i<$imgCount; $i++):?>
		<span></span>
		<?php endfor;?>
	</div>
</div>