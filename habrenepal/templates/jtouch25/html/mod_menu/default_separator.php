<?php
/**
 * @version		$Id: default_separator.php 21322 2011-05-11 01:10:29Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

// Note. It is important to remove spaces between elements.
$title = $item->anchor_title ? 'title="'.$item->anchor_title.'" ' : '';
if ($item->menu_image) {
		$item->params->get('menu_text', 1 ) ?
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" /><span class="image-title">'.$item->title.'</span> ' :
		$linktype = '<img src="'.$item->menu_image.'" alt="'.$item->title.'" />';
}
else { $linktype = $item->title;
}

?>
<?php
// MobileMe: If we have sub menu, move link to arrow icon
if($item->deeper): 
	// Ok, we do not need to show its RH link, just a reparator
	// <a href="#"><?php echo $linktype;</a>	
endif; ?>

<a href="" class="separator"><?php echo $title; ?><?php echo $linktype; ?></a>
