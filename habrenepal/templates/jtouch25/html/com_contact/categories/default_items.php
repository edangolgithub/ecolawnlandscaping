<?php
/**
 * @version		$Id: default_items.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
if (count($this->items[$this->parent->id]) > 0 && $this->maxLevelcat != 0) :
?>
<ul data-role="listview" data-inset="true">
<?php foreach($this->items[$this->parent->id] as $id => $item) : ?>
	<?php
	if($this->params->get('show_empty_categories_cat') || $item->numitems || count($item->getChildren())) :
	if(!isset($this->items[$this->parent->id][$id + 1]))
	{
		$class = ' class="last"';
	}
	?>
	<li<?php echo $class; ?>>
	<?php $class = ''; ?>
		<a href="<?php echo JRoute::_(ContactHelperRoute::getCategoryRoute($item->id));?>">
			<h3><?php echo $this->escape($item->title); ?></h3>
			<?php if ($this->params->get('show_subcat_desc_cat') == 1) :?>
				<?php if ($item->description) : ?>
					<p class="description">
						<?php echo strip_tags(JHtml::_('content.prepare', $item->description), '<img><br>'); ?>
					</p>
				<?php endif; ?>
	        <?php endif; ?>
	        
	        <?php if ($this->params->get('show_cat_items_cat') == 1) :?>
			<span class="ui-li-count">
				<?php echo $item->numitems; ?>
			</span>
			<?php endif; ?>
			
			<?php if(count($item->getChildren()) > 0) :?>
			<a href="<?php echo JRoute::_(ContactHelperRoute::getCategoryRoute($item->id));?>"></a>
			<?php
				$this->items[$item->id] = $item->getChildren();
				$this->parent = $item;
				$this->maxLevelcat--;
				echo $this->loadTemplate('items');
				$this->parent = $item->getParent();
				$this->maxLevelcat++;
			endif; ?>
		</a>
	</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif; ?>
