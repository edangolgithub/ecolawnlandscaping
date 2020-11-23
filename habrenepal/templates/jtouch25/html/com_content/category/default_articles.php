<?php
/**
 * @version		$Id: default_articles.php 22287 2011-10-26 05:32:17Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT.'/helpers/html');
//JHtml::_('behavior.tooltip');
//JHtml::core();

// Create some shortcuts.
$params		= &$this->item->params;
$n			= count($this->items);
$listOrder	= $this->escape($this->state->get('list.ordering'));
$listDirn	= $this->escape($this->state->get('list.direction'));
?>

<?php if (empty($this->items)) : ?>

	<?php if ($this->params->get('show_no_articles',1)) : ?>
	<p><?php echo JText::_('COM_CONTENT_NO_ARTICLES'); ?></p>
	<?php endif; ?>

<?php else : ?>
	<ul data-role="listview" data-inset="true">
		<?php foreach ($this->items as $i => $article) : ?>
			<li>
				<?php if (in_array($article->access, $this->user->getAuthorisedViewLevels())) : ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catid)); ?>">
					<h3><?php echo $this->escape($article->title); ?></h3>
					<p>
						<?php if ($this->params->get('list_show_date')) : ?>
						<?php echo JHtml::_('date',$article->displayDate, $this->escape(
							$this->params->get('date_format', JText::_('DATE_FORMAT_LC3')))); ?>
						<?php endif; ?>
						
						<?php if ($this->params->get('list_show_author',1) && !empty($article->author )) : ?>
						<br/>
							<?php $author =  $article->author ?>
							<?php $author = ($article->created_by_alias ? $article->created_by_alias : $author);?>
	
							<?php if (!empty($article->contactid ) &&  $this->params->get('link_author') == true):?>
								<?php echo JHtml::_(
										'link',
										JRoute::_('index.php?option=com_contact&view=contact&id='.$article->contactid),
										$author
								); ?>
	
							<?php else :?>
								<?php echo JText::sprintf('COM_CONTENT_WRITTEN_BY', $author); ?>
							<?php endif; ?>
						<?php endif; ?>
					</p>
					
					<?php if ($this->params->get('list_show_hits',1)) : ?>
					<span class="ui-li-count">
						<?php echo $article->hits; ?>
					</span>	
					<?php endif; ?>
				</a>
				<?php else: 
					// Show unauth links.
					$menu		= JFactory::getApplication()->getMenu();
					$active		= $menu->getActive();
					$itemId		= $active->id;
					$link = JRoute::_('index.php?option=com_users&view=login&Itemid='.$itemId);
					$returnURL = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug));
					$fullURL = new JURI($link);
					$fullURL->setVar('return', base64_encode($returnURL));
				?>
				<a href="<?php echo $fullURL; ?>" class="register">
					<?php echo $this->escape($article->title).' : '; ?>
					<?php echo JText::_( 'COM_CONTENT_REGISTER_TO_READ_MORE' ); ?>
				</a>
				<?php endif;?>
			</li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<form action="<?php echo htmlspecialchars(JFactory::getURI()->toString()); ?>" method="post" name="adminForm" id="adminForm" data-ajax="false" >
	<?php if ($this->params->get('show_headings') || $this->params->get('filter_field') != 'hide' || $this->params->get('show_pagination_limit')) :?>
	<fieldset class="filters">
		<?php if ($this->params->get('filter_field') != 'hide') :?>
		<h3>
			<?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?>
		</h3>

		<div data-role="fieldcontain" data-mini="true">
			<label class="filter-search-lbl" for="filter-search"><?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL').'&#160;'; ?></label>
			<input type="search" data-mini="true" name="filter-search" id="filter-search" value="<?php echo $this->escape($this->state->get('list.filter')); ?>" class="inputbox" onchange="document.adminForm.submit();" placeholder="<?php echo JText::_('COM_CONTENT_FILTER_SEARCH_DESC'); ?>" />
		</div>
		<?php endif; ?>

		<?php if ($this->params->get('show_pagination_limit')) : ?>
		<div data-role="fieldcontain" data-mini="true">
			<label for="limit"><?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?></label>
			<?php echo str_replace('class="inputbox"', 'data-mini="true"', $this->pagination->getLimitBox() ); ?>
		</div>
		<?php endif; ?>

		<!-- @TODO add hidden inputs -->
		<input type="hidden" name="filter_order" value="" />
		<input type="hidden" name="filter_order_Dir" value="" />
		<input type="hidden" name="limitstart" value="" />
	</fieldset>
	<?php endif; ?>

	<?php // Add pagination links ?>
	<?php if (!empty($this->items)) : ?>
		<?php if (($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
			 	<p class="counter">
					<?php echo $this->pagination->getPagesCounter(); ?>
				</p>
			<?php endif; ?>
	
			<?php echo $this->pagination->getPagesLinks(); ?>
			<div class="clr"></div>
		</div>
		<?php endif; ?>
</form>
<?php  endif; ?>
