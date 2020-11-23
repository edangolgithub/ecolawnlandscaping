<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_articles_news
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

$articleList = array();
foreach($list as $item){
	$imgPath = '';
	$images = json_decode($item->images);
	if(isset($images->image_intro) && strlen($images->image_intro) > 3){
		$imgPath  = htmlspecialchars($images->image_intro);
	} else {	
		$matches = array();
		preg_match('/src="([^"]*)"/i', $item->introtext, $matches);//'/(alt|title|src)=("[^"]*")/i
		if( isset($matches[1]) ){
			$imgPath = $matches[1]; 
		}else{
			// Has no image in this article
			$imgPath = JURI::base().'templates/jtouch25/banner.png';
		}
	}
	if(strpos($imgPath, 'http://') === false){
		$imgPath = JURI::base().$imgPath;
	}
	
	$article = array();
	
	$article['image'] = $imgPath;
	$article['title'] = $item->title;
	$article['link'] = $item->link;
	
	$articleList[] = $article;
}

// prevent multi modules conflict
$uniqueID = $module->id;

$document = JFactory::getDocument();
$document->addStyleSheet(JURI::base().'templates/jtouch25/html/mod_articles_category/assets/style-list.css', 'jtouch.cssfile');
//$document->addScript(JURI::base().'templates/jtouch25/client-libs/photoswipe/klass.min.js', 'jtouch.jsfile');
?>

<div class="jtouch-article-list <?php echo $moduleclass_sfx;?>">
	<?php foreach ($articleList as $item):?>
	<div class="item">
		<div class="image"><a href="<?php echo $item['link'];?>"><img src="<?php echo $item['image'];?>" /></a></div>
		<div class="content"><a href="<?php echo $item['link'];?>"><?php echo $item['title'];?></a></div>
		<div class="clr"></div>
	</div>
	<?php endforeach;?>
</div>
