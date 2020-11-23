<?php
/**
 * @version		$Id: default.php 21322 2011-05-11 01:10:29Z dextercowley $
 * @package		Joomla.Site
 * @subpackage	mod_login
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
JHtml::_('behavior.keepalive');
$document = JFactory::getDocument ();
?>
<?php if ($type == 'logout') : ?>
<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" data-ajax="false">
<?php if ($params->get('greeting')) : ?>
	<div class="login-greeting">
	<?php if($params->get('name') == 0) : {
		echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('name'));
	} else : {
		echo JText::sprintf('MOD_LOGIN_HINAME', $user->get('username'));
	} endif; ?>
	</div>
<?php endif; ?>
	<div class="logout-button">
		<input data-mini="true" data-inline="true" type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" data-inline="true" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
<?php else : ?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="loginform" class="form-validate" data-ajax="false">
	<?php if ($params->get('pretext')): ?>
		<p class="pretext">
			<?php echo $params->get('pretext'); ?>
		</p>
	<?php endif; ?>
		<div data-role="fieldcontain" class="ui-hide-label">
			<label for="modlgn-username"><?php echo JText::_('MOD_LOGIN_VALUE_USERNAME') ?></label>
			<input data-mini="true" id="modlgn-username" type="text" name="username" class="inputbox required" 
				placeholder="<?php echo JText::_('MOD_LOGIN_VALUE_USERNAME'); ?>" />
		</div>

		<div id="form-login-password" data-role="fieldcontain" class="ui-hide-label" >
			<label for="modlgn-passwd"><?php echo JText::_('JGLOBAL_PASSWORD') ?></label>
			<input data-mini="true" id="modlgn-passwd" type="password" name="password" class="inputbox required" 
			placeholder="<?php echo JText::_('JGLOBAL_PASSWORD'); ?>" />
		</div>
		
	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div id="form-login-remember" data-role="fieldcontain" >
			<label for="modlgn-remember"><?php echo JText::_('MOD_LOGIN_REMEMBER_ME') ?></label>
			<input data-mini="true" id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
		</div>
	<?php endif; ?>
	
	<input data-mini="true" data-inline="true" type="submit" name="Submit" class="button validate" onclick="jtouchValidateForm(loginform);" value="<?php echo JText::_('JLOGIN') ?>" />
	
	<input type="hidden" name="option" value="com_users" />
	<input type="hidden" name="task" value="user.login" />
	<input type="hidden" name="return" value="<?php echo $return; ?>" />
	<?php echo JHtml::_('form.token'); ?>
	
	<ul data-role="listview" data-inset="true" data-mini="true">
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
			<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
		</li>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
			<?php echo JText::_('MOD_LOGIN_FORGOT_YOUR_USERNAME'); ?></a>
		</li>
		<?php
		$usersConfig = JComponentHelper::getParams('com_users');
		if ($usersConfig->get('allowUserRegistration')) : ?>
		<li>
			<a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
				<?php echo JText::_('MOD_LOGIN_REGISTER'); ?></a>
		</li>
		<?php endif; ?>
	</ul>
	<?php if ($params->get('posttext')): ?>
		<div class="posttext">
		<p><?php echo $params->get('posttext'); ?></p>
		</div>
	<?php endif; ?>
</form>
<?php endif; ?>
