<?php
/**
 * @version		$Id: default.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_content
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
?>
<div class="archive<?php echo $this->pageclass_sfx;?>">
<?php if ($this->params->get('show_page_heading', 1)) : ?>
<h1 class="component-heading"><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
<?php endif; ?>

<?php echo $this->loadTemplate('items'); ?>

<form id="adminForm" action="<?php echo JRoute::_('index.php')?>" method="post" data-ajax="false">
	<fieldset class="filters">
	<h3><?php echo JText::_('JGLOBAL_FILTER_LABEL'); ?></h3>
	<div class="filter-search">
		<?php if ($this->params->get('filter_field') != 'hide') : ?>
		<div data-role="fieldcontain" data-mini="true">
			
			<input data-mini="true" type="search" name="filter-search" id="filter-search" class="inputbox" onchange="document.getElementById('adminForm').submit();" 
				value="<?php echo $this->escape($this->filter); ?>"
				placeholder="<?php echo JText::_('COM_CONTENT_'.$this->params->get('filter_field').'_FILTER_LABEL'); ?>" />
		</div>
		<?php endif; ?>
		
		<div data-role="fieldcontain" data-mini="true">
			<?php echo str_replace('class="inputbox"', 'data-mini="true"', $this->form->monthField); ?>
		</div>
		<div data-role="fieldcontain" data-mini="true">	
			<?php echo str_replace('class="inputbox"', 'data-mini="true"', $this->form->yearField); ?>
		</div>
		<div data-role="fieldcontain" data-mini="true">
			<?php echo str_replace('class="inputbox"', 'data-mini="true"', $this->form->limitField); ?>
		</div>
		
		<div data-role="fieldcontain" data-mini="true">
			<button type="submit" class="button" data-mini="true"><?php echo JText::_('JGLOBAL_FILTER_BUTTON'); ?></button>
		</div>
		
		
	</div>
	<input type="hidden" name="view" value="archive" />
	<input type="hidden" name="option" value="com_content" />
	<input type="hidden" name="limitstart" value="0" />
	</fieldset>
</form>
</div>
