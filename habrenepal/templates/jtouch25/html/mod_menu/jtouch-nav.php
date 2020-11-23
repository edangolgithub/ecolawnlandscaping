<?php
/**
 * @version		$Id: default.php 22355 2011-11-07 05:11:58Z github_bot $
 * @package		Joomla.Site
 * @subpackage	mod_menu
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;
require_once JPATH_ROOT.'/templates/jtouch25/utils/jtouch25.utils.php';
$tpl = Jtouch25Utils::getJtouchTemplate();
$pageTheme = 'd';
$headerTheme = 'd';
if($tpl){
	$tplParams = new JRegistry($tpl->params);
	$pageTheme = $tplParams->get('jtouch-theme', 'd');
	$headerTheme = $tplParams->get('jtouch-header-theme', 'd');
	
}
// Note. It is important to remove spaces between elements.
$class_sfx = '-nav';
?>
<ul data-role="listview<?php echo $class_sfx;?>" data-inset="true" data-split-theme="<?php echo $pageTheme; ?>" data-theme="<?php echo $pageTheme; ?>" class="menu<?php echo $class_sfx;?>"<?php
	$tag = '';
	if ($params->get('tag_id')!=NULL) {
		$tag = $params->get('tag_id').'';
		echo ' id="'.$tag.'"';
	}
?>>
<?php
foreach ($list as $i => &$item) :
	$dataTheme = ' ';
	$class = 'item-'.$item->id;
	if ($item->id == $active_id) {
		$class .= ' current';
	}

	if (	$item->type == 'alias' &&
			in_array($item->params->get('aliasoptions'),$path)
		||	in_array($item->id, $path)) {
		$class .= ' active';
	}

	if ($item->deeper) {
		$class .= ' deeper';
		$dataTheme = '  ';
	}

	if ($item->parent) {
		$class .= ' parent';
	}

	if (!empty($class)) {
		$class = ' class="'.trim($class) .'"';
	}

	echo '<li'.$class.$dataTheme.' >';

	// Render the menu item.
	switch ($item->type) :
		case 'separator':
		case 'url':
		case 'component':
			require JModuleHelper::getLayoutPath('mod_menu', 'default_'.$item->type);
			break;

		default:
			require JModuleHelper::getLayoutPath('mod_menu', 'default_url');
			break;
	endswitch;

	// The next item is deeper.
	if ($item->deeper) {
		echo '<ul data-role="listview" data-inset="true" data-split-theme="'.$pageTheme.'" data-theme="'.$pageTheme.'">';
	}
	// The next item is shallower.
	elseif ($item->shallower) {
		echo '</li>';
		echo str_repeat('</ul></li>', $item->level_diff);
	}
	// The next item is on the same level.
	else {
		echo '</li>';
	}
endforeach;
?></ul>
