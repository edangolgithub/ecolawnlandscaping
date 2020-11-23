<?php
/**
 * @version		$Id: default.php 22338 2011-11-04 17:24:53Z github_bot $
 * @package		Joomla.Site
 * @subpackage	com_users
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @since		1.5
 */

defined('_JEXEC') or die;

//JHtml::_('behavior.keepalive');
//JHtml::_('behavior.tooltip');
//JHtml::_('behavior.formvalidation');
?>
<div class="reset<?php echo $this->pageclass_sfx?>">
	<?php if ($this->params->get('show_page_heading')) : ?>
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>

	<form id="userregistration" action="<?php echo JRoute::_('index.php?option=com_users&task=reset.request'); ?>" method="post" class="form-validate" data-ajax="false">

		<?php foreach ($this->form->getFieldsets() as $fieldset): ?>
		<p><?php echo JText::_($fieldset->label); ?></p>		
			<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field): ?>
				<fieldset data-role="controlgroup" data-mini="true">
					<?php echo $field->label; ?>
					<?php echo $field->input; ?>
				</fieldset>
			<?php endforeach; ?>
		<?php endforeach; ?>

		<fieldset data-role="controlgroup" data-mini="true">
			<button data-mini="true" data-inline="true" type="submit" class="validate" onclick="jtouchValidateForm(userregistration);"><?php echo JText::_('JSUBMIT'); ?></button>
			<?php echo JHtml::_('form.token'); ?>
		</fieldset>
	</form>
</div>
