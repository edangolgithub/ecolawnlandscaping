<?php
/**
 * @version		$Id: default_children.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';

if (count($this->children[$this->category->id]) > 0 && $this->maxLevel != 0) :
?>
<ul data-role="listview" data-inset="true">
<?php foreach($this->children[$this->category->id] as $id => $child) : ?>
	<?php
	if($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
	if(!isset($this->children[$this->category->id][$id + 1]))
	{
		$class = ' class="last"';
	}
	?>
	<li<?php echo $class; ?>>
		<?php $class = ''; ?>
			<a href="<?php echo JRoute::_(ContactHelperRoute::getCategoryRoute($child->id));?>">
				<h3><?php echo $this->escape($child->title); ?></h3>
				<?php if ($this->params->get('show_subcat_desc') == 1) :?>
					<?php if ($child->description) : ?>
						<p class="description">
							<?php echo JHtml::_('content.prepare', $child->description); ?>
						</p>
					<?php endif; ?>
	            <?php endif; ?>
	            <?php if ($this->params->get('show_cat_items') == 1) :?>
					<span class="ui-li-count">
						<?php echo $child->numitems; ?>
					</span>
				<?php endif; ?>
		            <?php if(count($child->getChildren()) > 0 ) : ?>
		            <a href="<?php echo JRoute::_(ContactHelperRoute::getCategoryRoute($child->id));?>">
		            <?php
						$this->children[$child->id] = $child->getChildren();
						$this->category = $child;
						$this->maxLevel--;
						echo $this->loadTemplate('children');
						$this->category = $child->getParent();
						$this->maxLevel++;
					endif; ?>
			</a>
		</li>
	<?php endif; ?>
<?php endforeach; ?>
</ul>
<?php endif;
