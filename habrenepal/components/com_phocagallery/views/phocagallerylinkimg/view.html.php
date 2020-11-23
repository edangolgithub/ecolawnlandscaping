<?php
/*
 * @package Joomla 1.5
 * @copyright Copyright (C) 2005 Open Source Matters. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 *
 * @component Phoca Component
 * @copyright Copyright (C) Jan Pavelka www.phoca.cz
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */ 
defined('_JEXEC') or die();
jimport( 'joomla.application.component.view' );
 
class phocaGalleryViewphocaGalleryLinkImg extends JView
{
	var $_context 	= 'com_phocagallery.phocagallerylinkimg';

	function display($tpl = null) {
		$app	= JFactory::getApplication();
		
		//Frontend Changes
		$tUri = '';
		$jsLink = JURI::base(true);
		if (!$app->isAdmin()) {
			$tUri = JURI::base();
			phocagalleryimport('phocagallery.render.renderadmin');
			phocagalleryimport('phocagallery.file.filethumbnail');
			$jsLink = JURI::base(true).'/administrator';
		}
		$document	=& JFactory::getDocument();
		$uri		=& JFactory::getURI();
		$db		    =& JFactory::getDBO();
		JHtml::stylesheet( 'administrator/components/com_phocagallery/assets/phocagallery.css' );
		JHtml::stylesheet( 'administrator/components/com_phocagallery/assets/jcp/picker.css' );
		$document->addScript($jsLink . '/components/com_phocagallery/assets/jcp/picker.js');
		
		$eName				= JRequest::getVar('e_name');
		$tmpl['ename']		= preg_replace( '#[^A-Z0-9\-\_\[\]]#i', '', $eName );
		$tmpl['type']		= JRequest::getVar( 'type', 1, '', 'int' );
		$tmpl['backlink']	= $tUri.'index.php?option=com_phocagallery&amp;view=phocagallerylinks&amp;tmpl=component&amp;e_name='.$tmpl['ename'];
		
		
		
		$document->addCustomTag("<!--[if lt IE 8]>\n<link rel=\"stylesheet\" href=\"../administrator/components/com_phocagallery/assets/phocagalleryieall.css\" type=\"text/css\" />\n<![endif]-->");
		
		$params = JComponentHelper::getParams('com_phocagallery') ;

		//Filter
		
		$filter_state		= $app->getUserStateFromRequest( $this->_context.'.filter_state',	'filter_state', '',	'word' );
		$filter_catid		= $app->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0, 'int' );
		$filter_order		= $app->getUserStateFromRequest( $this->_context.'.filter_order',	'filter_order',	'a.ordering', 'cmd' );
		$filter_order_Dir	= $app->getUserStateFromRequest( $this->_context.'.filter_order_Dir',	'filter_order_Dir',	'',	'word' );
		$search				= $app->getUserStateFromRequest( $this->_context.'.search', 'search', '',	'string' );
		$search				= JString::strtolower( $search );

		// Get data from the model
		$items					= & $this->get( 'Data');
		$total					= & $this->get( 'Total');
		$tmpl['pagination'] 	= & $this->get( 'Pagination' );
		
		// build list of categories
		$javascript 	= 'class="inputbox" size="1" onchange="submitform( );"';
		
		// get list of categories for dropdown filter	
		$filter = '';
		
		// build list of categories
		$javascript 	= 'class="inputbox" size="1" onchange="submitform( );"';
		
		$query = 'SELECT a.title AS text, a.id AS value, a.parent_id as parentid'
		. ' FROM #__phocagallery_categories AS a'
		. ' WHERE a.published = 1'
		. ' AND a.approved = 1'
		. ' ORDER BY a.ordering';
		$db->setQuery( $query );
		$phocagallerys = $db->loadObjectList();

		$tree = array();
		$text = '';
		$tree = PhocaGalleryRenderAdmin::CategoryTreeOption($phocagallerys, $tree, 0, $text, -1);
		array_unshift($tree, JHtml::_('select.option', '0', '- '.JText::_('COM_PHOCAGALLERY_SELECT_CATEGORY').' -', 'value', 'text'));
		$lists['catid'] = JHtml::_( 'select.genericlist', $tree, 'filter_catid',  $javascript , 'value', 'text', $filter_catid );
		//-----------------------------------------------------------------------
	
		// state filter
		$lists['state']		= JHtml::_('grid.state',  $filter_state );

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] 	= $filter_order;

		// search filter
		$lists['search']	= $search;
		
		$this->assignRef('tmpl',		$tmpl);
		$this->assignRef('button',		$button);
		$this->assignRef('user',		JFactory::getUser());
		$this->assignRef('items',		$items);
		$this->assignRef('request_url',	$uri->toString());
		
		switch($tmpl['type']) {
			
			case 2:
			
				$i = 0;
				$itemsCount = $itemsStart = array();
				foreach($items as $key => $value) {
				
					$itemsCount[$i]->value 	= $key;
					$itemsCount[$i]->text	= $key;
					$itemsStart[$i]->value 	= $key;
					$itemsStart[$i]->text	= $key;
					$i++;
				}
				
				// Don't display it if no category is selected
				if($i > 0) {
					$itemsCount[$i]->value 	= (int)$key + 1;
					$itemsCount[$i]->text	= (int)$key + 1;
				}
				$categoryId		= JRequest::getVar( 'filter_catid', 0, '', 'int' );
				$categoryIdList	= $app->getUserStateFromRequest( $this->_context.'.filter_catid',	'filter_catid',	0, 'int' );
				
				if ((int)$categoryId == 0 && $categoryIdList == 0) {
					$itemsCount = $itemsStart = array();
				}
				
				$lists['limitstartparam'] = JHtml::_( 'select.genericlist', $itemsStart, 'limitstartparam',  '' , 'value', 'text', '' );
				$lists['limitcountparam'] = JHtml::_( 'select.genericlist', $itemsCount, 'limitcountparam',  '' , 'value', 'text', '' );
				$this->assignRef('lists',		$lists);
				parent::display('images');
			break;
		
			case 3:
				$this->assignRef('lists',		$lists);
				parent::display('switchimage');
			break;
			
			case 4:
				$this->assignRef('lists',		$lists);
				parent::display('slideshow');
			break;
		
			case 1:
			Default:
				$this->assignRef('lists',		$lists);
				parent::display($tpl);
			break;
		
		}
	}
}
?>