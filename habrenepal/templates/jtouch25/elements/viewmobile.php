<?php
/**
 * @package 	Jtouch.Template
 * @author		Nguyen Mobile
 * @copyright	Copyright (C) 2011 - 2013 JTouchMobile.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

defined('JPATH_BASE') or die;

jimport('joomla.form.formfield');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package		Joomla.Framework
 * @subpackage	Form
 * @since		1.6
 */
class JFormFieldViewmobile extends JFormField
{
	/**
	 * The form field type.
	 *
	 * @var		string
	 * @since	1.6
	 */
	protected $type = 'Viewmobile';

	/**
	 * Method to get the field input markup.
	 *
	 * @return	string	The field input markup.
	 * @since	1.6
	 */
	protected function getInput()
	{
		return ' ';
	}

	/**
	 * Method to get the field label markup.
	 *
	 * @return	string	The field label markup.
	 * @since	1.6
	 */
	protected function getLabel()
	{
		JHTML::_('behavior.modal');
		$document = JFactory::getDocument();
		$jsCode = <<<EOL
		
		function jtClosePreviewBox(){
			$('sbox-btn-close').click();
		}
EOL;
		$document->addScriptDeclaration($jsCode);
		
		$url = JURI::root(true).'/templates/jtouch25/elements/viewmobile.html';
		$content = '<div class="clr"></div><a href="'.$url.'" class="modal jt-button"  rel="{handler: \'iframe\', size: {x: 500, y: 560}}"><span class="icon16 icon-web">'.JText::_('JTOUCH25_TPL_VIEW_MOBILE').'</span></a><div class="clr"></div>';
		
		return $content;
	}
	
	/**
	 * Method to get the field title.
	 *
	 * @return	string	The field title.
	 * @since	1.6
	 */
	protected function getTitle()
	{
		return $this->getLabel();
	}
}
