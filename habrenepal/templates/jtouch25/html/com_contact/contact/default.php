<?php
 /**
 * $Id: default.php 21321 2011-05-11 01:05:59Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$cparams = JComponentHelper::getParams ('com_media');
?>

	<h1>
		<?php if ($this->params->get('show_page_heading', 1)) : ?>
			<?php echo $this->escape($this->params->get('page_heading')); ?>
			:
		<?php endif; ?>
		<?php if ($this->contact->name && $this->params->get('show_name')) : ?>
			<span class="contact-name"><?php echo $this->contact->name; ?></span>
	<?php endif;  ?>
	</h1>

	<?php if ($this->params->get('show_contact_category') == 'show_no_link') : ?>
		<h3>
			<span class="contact-category"><?php echo $this->contact->category_title; ?></span>
		</h3>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_contact_category') == 'show_with_link') : ?>
		<?php $contactLink = ContactHelperRoute::getCategoryRoute($this->contact->catid);?>
		<h3>
			<span class="contact-category"><a href="<?php echo $contactLink; ?>">
				<?php echo $this->escape($this->contact->category_title); ?></a>
			</span>
		</h3>
	<?php endif; ?>
	
	<?php if ($this->params->get('show_contact_list') && count($this->contacts) > 1) : ?>
		<form action="#" method="get" name="selectForm" id="selectForm">
			<?php echo JText::_('COM_CONTACT_SELECT_CONTACT'); ?>
			<?php echo JHtml::_('select.genericlist',  $this->contacts, 'id', 'class="inputbox" onchange="document.location.href = this.value"', 'link', 'name', $this->contact->link);?>
		</form>
	<?php endif; ?>
	
	<!-- COLLAPSIBLE SET -->
	<div data-role="collapsible-set-lock">
		<!-- contact details -->
		<div data-role="collapsible" data-collapsed="false">
			<h3><?php  echo JText::_('COM_CONTACT_DETAILS');  ?></h3>
			<?php if ($this->contact->image && $this->params->get('show_image')) : ?>
			<div class="contact-image">
				<?php echo JHtml::_('image',$this->contact->image, JText::_('COM_CONTACT_IMAGE_DETAILS'), array('align' => 'middle')); ?>
			</div>
			<?php endif; ?>
		
			<?php if ($this->contact->con_position && $this->params->get('show_position')) : ?>
				<p class="contact-position"><?php echo $this->contact->con_position; ?></p>
			<?php endif; ?>
		
			<?php echo $this->loadTemplate('address'); ?>
		
			<?php if ($this->params->get('allow_vcard')) :	?>
				<?php echo JText::_('COM_CONTACT_DOWNLOAD_INFORMATION_AS');?>
					<a href="<?php echo JRoute::_('index.php?option=com_contact&amp;view=contact&amp;id='.$this->contact->id . '&amp;format=vcf'); ?>">
					<?php echo JText::_('COM_CONTACT_VCARD');?></a>
			<?php endif; ?>
			
		</div>
		<!-- contact details:end -->
		
		<!-- article -->
		<?php if ($this->params->get('show_articles') && $this->contact->user_id && $this->contact->articles) : ?>
		<div data-role="collapsible">
			<h3><?php echo JText::_('JGLOBAL_ARTICLES'); ?></h3>
			<?php echo $this->loadTemplate('articles'); ?>
		</div>
		<?php endif;?>
		<!-- article:end -->
		
		<!-- profile -->
		<?php if ($this->params->get('show_profile') && $this->contact->user_id && JPluginHelper::isEnabled('user', 'profile')) : ?>
		<div data-role="collapsible">
			<h3><?php echo JText::_('COM_CONTACT_PROFILE'); ?></h3>
			<?php echo $this->loadTemplate('profile'); ?>
		</div>
		<?php endif;?>
		<!-- profile:end -->

		<!-- link -->
		<?php if ($this->params->get('show_links')) : ?>
		<div data-role="collapsible">
			<h3><?php  echo JText::_('COM_CONTACT_LINKS');  ?></h3>
			<?php echo $this->loadTemplate('links'); ?>
		</div>
		<?php endif; ?>
		<!-- link:end -->
		
		<!-- other -->
		<?php if ($this->contact->misc && $this->params->get('show_misc')) : ?>
		<div data-role="collapsible">
			<h3><?php echo JText::_('COM_CONTACT_OTHER_INFORMATION'); ?></h3>
			<div class="contact-miscinfo">
				<div class="<?php echo $this->params->get('marker_class'); ?>">
					<?php echo $this->params->get('marker_misc'); ?>
				</div>
				<div class="contact-misc">
					<?php echo $this->contact->misc; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<!-- other:end -->

		<!-- form -->
		<?php if ($this->params->get('show_email_form') && ($this->contact->email_to || $this->contact->user_id)) : ?>
		<div data-role="collapsible">
			<h3><?php  echo JText::_('COM_CONTACT_EMAIL_FORM');  ?></h3>
			<?php  echo $this->loadTemplate('form');  ?>
		</div>
		<?php endif; ?>
		<!-- form:end -->
		
	</div>
	<!-- COLLAPSIBLE SET:END -->