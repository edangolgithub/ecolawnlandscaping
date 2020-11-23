<?php
/**
 * @version		$Id: default_children.php 20196 2011-01-09 02:40:25Z ian $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$class = ' class="first"';
?>

<?php if (count($this->children[$this->category->id]) > 0) : ?>
	<ul>
	<?php foreach($this->children[$this->category->id] as $id => $child) : ?>
		<?php
		if ($this->params->get('show_empty_categories') || $child->getNumItems(true) || count($child->getChildren())) :
			if (!isset($this->children[$this->category->id][$id + 1])) :
				$class = ' class="last"';
			endif;
		?>

		<li<?php echo $class; ?>>
			<?php $class = ''; ?>
			
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id));?>">
				<h3><?php echo $this->escape($child->title); ?></h3>
				
				<?php if ($this->params->get('show_subcat_desc') == 1) :?>
					<?php if ($child->description) : ?>
						<p class="description">
							<?php echo strip_tags(JHtml::_('content.prepare', $child->description), '<img><br>'); ?>
						</p>
					<?php endif; ?>
				<?php endif; ?>
				
				<?php if ( $this->params->get('show_cat_num_articles',1)) : ?>
				<span class="ui-li-count">(
					<?php echo JText::_('COM_CONTENT_NUM_ITEMS') ; ?>
					<?php echo $child->getNumItems(true); ?>
				)</span>
				<?php endif ; ?>
			</a>
			<?php
				if (count($child->getChildren()) > 0 ) :
					$this->children[$child->id] = $child->getChildren();
					$this->category = $child;
					$this->maxLevel--;
					if ($this->maxLevel != 0) :
						echo $this->loadTemplate('children');
					endif;
					$this->category = $child->getParent();
					$this->maxLevel++;
				endif;
			?>
			
		</li>
		<?php endif; ?>
	<?php endforeach; ?>
	</ul>
<?php endif; ?>
