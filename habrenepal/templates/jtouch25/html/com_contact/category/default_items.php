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

JHtml::core();

$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>
<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_CONTACT_NO_ARTICLES'); ?>	 </p>
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
	<?php endforeach; ?>
</ul>

<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm" data-ajax="false">
	<?php if ($this->params->get('show_pagination_limit')) : ?>
	<fieldset class="filters">
		<h3><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?></h3>

		<div class="display-limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>&#160;
			<?php echo $this->pagination->getLimitBox(); ?>
		</div>
	</fieldset>
	<?php endif; ?>

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

	<div>
		<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
		<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
	</div>
</form>
<?php endif; ?>
