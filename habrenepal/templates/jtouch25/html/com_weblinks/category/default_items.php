<?php
/**
 * @version		$Id: default_items.php 13471 2009-11-12 00:38:49Z eddieajau
 * @package		Joomla.Site
 * @subpackage	com_weblinks
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
// Code to support edit links for weblinks
// Create a shortcut for params.
$params = &$this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::core();

// Get the user object.
$user = JFactory::getUser();
// Check if user is allowed to add/edit based on weblinks permissinos.
$canEdit = $user->authorise('core.edit', 'com_weblinks');
$canCreate = $user->authorise('core.create', 'com_weblinks');
$canEditState = $user->authorise('core.edit.state', 'com_weblinks');

$n = count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<?php if (empty($this->items)) : ?>
	<p> <?php echo JText::_('COM_WEBLINKS_NO_WEBLINKS'); ?></p>
<?php else : ?>
	<ul data-role="listview" data-inset="true">
	<?php foreach ($this->items as $i => $item) : ?>
		<li>
			<?php 
			$link = $item->link;
			?>
			<a href="<?php echo $link?>" target="_blank">
				<?php echo $this->escape($item->title);?>
				<p>
					<?php if (($this->params->get('show_link_description')) and ($item->description !='')): ?>
						<?php echo $item->description; ?>
					<?php endif; ?>
				</p>
				<?php if ($this->params->get('show_link_hits')) : ?>
				<span class="ui-li-count">
					<?php echo $item->hits; ?>
				</span>
				<?php endif;?>
			</a>
		</li>	
	<?php endforeach; ?>
	</ul>
	
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
<?php endif; ?>
