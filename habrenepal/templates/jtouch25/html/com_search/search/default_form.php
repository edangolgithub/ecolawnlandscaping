<?php
/**
 * @version		$Id: default_form.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_search
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$lang = JFactory::getLanguage();
$upper_limit = $lang->getUpperLimitSearchWord();
?>
<div class="clr"></div>
<h2><?php echo JText::_('COM_SEARCH_SEARCH');?></h2>
<form id="searchForm" action="<?php echo JRoute::_('index.php?option=com_search');?>" method="post" data-ajax="false">
	<fieldset class="word">
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="search-searchword"><?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?></label>
			<input type="text" name="searchword" id="search-searchword" 
				maxlength="<?php echo $upper_limit; ?>" value="<?php echo $this->escape($this->origkeyword); ?>"
				placeholder="<?php echo JText::_('COM_SEARCH_SEARCH_KEYWORD'); ?>" />
		</div>
		
		<button name="Search" onclick="this.form.submit()" class="button"><?php echo JText::_('COM_SEARCH_SEARCH');?></button>
		<input type="hidden" name="task" value="search" />
	</fieldset>

	<div class="searchintro<?php echo $this->params->get('pageclass_sfx'); ?>">
		<?php if (!empty($this->searchword)):?>
		<p><?php echo JText::plural('COM_SEARCH_SEARCH_KEYWORD_N_RESULTS', $this->total);?></p>
		<?php endif;?>
	</div>
		
	<div data-role="fieldcontain">
		<legend><?php echo JText::_('COM_SEARCH_FOR');?></legend>
		<fieldset data-role="controlgroup">
			<?php echo $this->lists['searchphrase']; ?>
		</fieldset>
	</div>
	
	
	<div data-role="fieldcontain">
		<label for="ordering" class="ordering">
			<?php echo JText::_('COM_SEARCH_ORDERING');?>
		</label>
		<?php echo $this->lists['ordering'];?>
	</div>
	

	<?php if ($this->params->get('search_areas', 1)) : ?>
	<div data-role="fieldcontain">
		<fieldset data-role="controlgroup">
		<legend><?php echo JText::_('COM_SEARCH_SEARCH_ONLY');?></legend>
		<?php foreach ($this->searchareas['search'] as $val => $txt) :
			$checked = is_array($this->searchareas['active']) && in_array($val, $this->searchareas['active']) ? 'checked="checked"' : '';
		?>
		<input type="checkbox" name="areas[]" value="<?php echo $val;?>" id="area-<?php echo $val;?>" <?php echo $checked;?> />
			<label for="area-<?php echo $val;?>">
				<?php echo JText::_($txt); ?>
			</label>
		<?php endforeach; ?>
		</fieldset>
	</div>
	<?php endif; ?>

<?php if ($this->total > 0) : ?>
	<div data-role="fieldcontain">
		<label for="limit">
			<?php echo JText::_('JGLOBAL_DISPLAY_NUM'); ?>
		</label>
		<?php echo $this->pagination->getLimitBox(); ?>
	</div>
	
	<div class="clr"></div>
	<p class="counter">
		<?php echo $this->pagination->getPagesCounter(); ?>
	</p>
<?php endif; ?>

</form>
