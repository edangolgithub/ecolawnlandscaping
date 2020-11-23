<?php

 /**
 * @version		$Id: default_form.php 11845 2009-05-27 23:28:59Z robs
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
//JHtml::_('behavior.keepalive');
//JHtml::_('behavior.formvalidation');
//JHtml::_('behavior.tooltip');
 if (isset($this->error)) : ?>
	<div class="contact-error">
		<?php echo $this->error; ?>
	</div>
<?php endif; ?>

<div class="contact-form">
	<script type="text/javascript">
	function contactFormCheck(){
		var isError = false;
		var isFocused = false;
		// Check Contact name
		if($('#jform_contact_name').val() == ''){
			isError = true;
			$('#jform_contact_name').addClass('ui-body-e');
			if(!isFocused) {
				$('#jform_contact_name').focus();
				isFocused = true;
			}	
		}
		// Email
		var email = $('#jform_contact_email').val();
		if ( ( email == "" ) || ( email.search("@") == -1 ) || ( email.search("[.*]" ) == -1 ) ) {
			isError = true;
			$('#jform_contact_email').addClass('ui-body-e');
			if(!isFocused) {
				$('#jform_contact_email').focus();
				isFocused = true;
			}
		}
		// Subject
		if($('#jform_contact_emailmsg').val() == ''){
			isError = true;
			$('#jform_contact_emailmsg').addClass('ui-body-e');
			if(!isFocused) {
				$('#jform_contact_emailmsg').focus();
				isFocused = true;
			}	
		}
		// Message
		if($('#jform_contact_message').val() == ''){
			isError = true;
			$('#jform_contact_message').addClass('ui-body-e');
			if(!isFocused) {
				$('#jform_contact_message').focus();
				isFocused = true;
			}	
		}

		if(isError){
			$('#contact_button').addClass('ui-body-e');
		}
		return !isError;
	}
	</script>
	<form id="contact-form" action="<?php echo JRoute::_('index.php'); ?>" method="post" class="form-validate" data-ajax="false">
		<div><?php echo JText::_('COM_CONTACT_FORM_LABEL'); ?></div>

		<fieldset data-role="controlgroup" data-mini="true">
			<?php echo $this->form->getLabel('contact_name'); ?>
			<?php echo $this->form->getInput('contact_name'); ?>
		</fieldset>
		<fieldset data-role="controlgroup" data-mini="true">
			<?php echo $this->form->getLabel('contact_email'); ?>
			<?php echo $this->form->getInput('contact_email'); ?>
		</fieldset>
		<fieldset data-role="controlgroup" data-mini="true">
			<?php echo $this->form->getLabel('contact_subject'); ?>
			<?php echo $this->form->getInput('contact_subject'); ?>
		</fieldset>
		<fieldset data-role="controlgroup" data-mini="true">
			<?php echo $this->form->getLabel('contact_message'); ?>
			<?php echo $this->form->getInput('contact_message'); ?>
		</fieldset>
		<?php 	if ($this->params->get('show_email_copy')){ ?>
		<div data-role="fieldcontain">
			<fieldset data-role="controlgroup" data-mini="true">
			   <?php echo $this->form->getLabel('contact_email_copy'); ?>
			   <?php echo $this->form->getInput('contact_email_copy'); ?>
		    </fieldset>
		</div>
		<?php 	} ?>
	<?php //Dynamically load any additional fields from plugins. ?>
	     <?php foreach ($this->form->getFieldsets() as $fieldset): ?>
	          <?php if ($fieldset->name != 'contact'):?>
	               <?php $fields = $this->form->getFieldset($fieldset->name);?>
	               <?php foreach($fields as $field): ?>
	                    <?php if ($field->hidden): ?>
	                         <?php echo $field->input;?>
	                    <?php else:?>
	                    	<fieldset data-role="controlgroup" data-mini="true">
	                            <?php echo $field->label; ?>
	                            <?php if (!$field->required && $field->type != "Spacer"): ?>
	                               <span class="optional"><?php echo JText::_('COM_CONTACT_OPTIONAL');?></span>
	                            <?php endif; ?>
	                         <?php echo $field->input;?>
	                         </fieldset>
	                    <?php endif;?>
	               <?php endforeach;?>
	          <?php endif ?>
	     <?php endforeach;?>
		<p> </p>
		
		<fieldset data-role="controlgroup" data-mini="true">
			<button class="button validate" type="submit" onClick="return contactFormCheck();"><?php echo JText::_('COM_CONTACT_CONTACT_SEND'); ?></button>
	    </fieldset>

		<input type="hidden" name="option" value="com_contact" />
		<input type="hidden" name="task" value="contact.submit" />
		<input type="hidden" name="return" value="<?php echo $this->return_page;?>" />
		<input type="hidden" name="id" value="<?php echo $this->contact->slug; ?>" />
		<?php echo JHtml::_( 'form.token' ); ?>
	</form>
</div>
