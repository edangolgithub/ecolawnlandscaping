<?php
/**
 * @version		$Id: default_items.php 21700 2011-06-28 04:32:41Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::core();

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));

// Create a shortcut for params.
$params = &$this->item->params;
?>

<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_CONTACT_NO_CONTACTS'); ?>	 </p>
<?php else : ?>

<ul data-role="listview" data-inset="true">
	<?php foreach($this->items as $i => $item) : ?>
	<li>
		<a href="<?php echo JRoute::_(ContactHelperRoute::getContactRoute($item->slug, $item->catid)); ?>">
			<h3><?php echo $item->name; ?></h3>
			<p class="description">
				<?php if ($this->params->get('show_position_headings')) : ?>
					<?php echo $item->con_position; ?><br />
				<?php endif; ?>
				<?php if ($this->params->get('show_email_headings')) : ?>
					<?php echo $item->email_to; ?><br />
			<?php endif; ?>
			</p>
		</a>
	</li>
	<?php endforeach;?>
</ul>

<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm" data-ajax="false">
	<fieldset class="filters">
		<h3><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?></h3>
		<?php if ($this->params->get('show_pagination_limit')) : ?>
			<div class="display-limit">
				<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
				<?php echo $this->pagination->getLimitBox(); ?>
			</div>
		<?php endif; ?>
		
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</fieldset>

	<?php if ($this->params->get('show_pagination')) : ?>
	<div class="pagination">
		<?php if ($this->params->def('show_pagination_results', 1)) : ?>
		<p class="counter">
			<?php echo $this->pagination->getPagesCounter(); ?>
		</p>
		<?php endif; ?>
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php endif; ?>
</form>
<?php endif; ?>

<div class="item-separator"></div>
