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
//die(var_dump($list));

$menuPages = array();
$itemList = array();
foreach ($list as $item):
	$id = ($item->parent_id != false)? $item->parent_id : 0;
	$menuPages[$id][] = $item;
	$itemList[$item->id] = $item;
endforeach;

//echo " we have ".count($menuPages). ' menu pages!';
//die(var_dump($menuPages));

// Generate page for each level of menu
$menuCounter = 0;
$menuPagesID = 'jtmenupages'.$module->id;
$menuTitle = $module->title;
$menuId	= $module->id;
$menuStyle = 'data-role="listview" data-inset="true" data-split-icon="forward" data-split-theme="'.$pageTheme .'" data-theme="'. $pageTheme .'" class="menu'.$class_sfx.'" ';
$firstLevel = $list[0]->parent_id;
echo '<!-- Draw first level of the menu --><ul '.$menuStyle.'>';
foreach ($menuPages[$firstLevel] as $item) {
	$href =  $item->flink;
	// if there has another sub menu? this menu item will link to this submenu page
	$splitIcon = '';
	if ($item->deeper) {
		if ($item->type != 'separator'){
			$splitIcon = '<a href="'.$href.'">Deeper</a>';
		}
		$href = "#jt-menu-".$module->id.'-'.$item->id;
	}
	$title = $item->title;
	echo '<li><a href="'.$href.'">'.$title.'</a>'.$splitIcon.'</li>';
}
echo '</ul><!-- End: Draw first level of the menu -->';

echo '<!-- Draw mobile menu pages --><script type = "text/template" id="'.$menuPagesID.'">';
foreach ($menuPages as $parentID => $menu):
	$menuCounter ++;
	$menuId = 'jt-menu-'.$module->id.'-'.$parentID;
	if( $parentID > 0 && isset($itemList[$parentID])){
		$menuTitle = $itemList[$parentID]->title;
		$parentMenuPage = '#jt-menu-'.$module->id.'-'.$itemList[$parentID]->id;
	}
	
	?>
	<div data-role="page" data-theme="<?php echo $pageTheme;?>" class="jt-menu-page" id="<?php echo $menuId;?>">
		<div data-role="header" data-theme="<?php echo $headerTheme;?>">
			<a data-rel="back"  data-icon="arrow-l" data-role="button" class="jt-back-button"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
			<a href="#jt-page-menu" data-icon="grid" class="ui-btn-right"><?php echo JText::_('TPL_JTOUCH25_MENU_MENU');?></a>
			<h1><?php echo $menuTitle;?></h1>
		</div>
		<div data-role="content">
			<ul <?php echo $menuStyle;?> >
	<?php
	if(count($menu) < 1) continue;
	foreach ($menu as $item):
		$href =  $item->flink;
		$splitIcon = '';
		// if there has another sub menu? this menu item will link to this submenu page
		if ($item->deeper) {
			if ($item->type != 'separator'){
				$splitIcon = '<a href="'.$href.'">Deeper</a>';
			}
			$href = "#jt-menu-".$item->id;
		}	
		$title = $item->title;
		echo '<li><a href="'.$href.'">'.$title.'</a>'.$splitIcon.'</li>';
	endforeach;
	?>
			</ul>
		</div>
	</div><!-- end menu#<?php echo $menuCounter; ?> -->
<?php
endforeach;

echo '</script><!-- End: Draw mobile menu -->';
?>
<script type="text/javascript">
(function($){
	$(document).ready(function() {
		jtouchLog('Building mobile menu: <?php echo $menuPagesID;?> ..');
		$('#jt-body-root').append(
				_.template($('#<?php echo $menuPagesID;?>').html())
		);
	});
	/*
	$(document).bind('pageshow', function (){
		jtouchLog('Init mobile menus..');
		$$('.jt-menu-page').page();
	});*/
})(jQuery);
</script>
