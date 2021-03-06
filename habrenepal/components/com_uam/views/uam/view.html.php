<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');
jimport ('joomla.html.parameter');

if (!defined('DIRECTORY_SEPARATOR'))
	define('DIRECTORY_SEPARATOR', DS);

if (!function_exists('class_alias')) {
    function class_alias($original, $alias) {
        eval('class ' . $alias . ' extends ' . $original . ' {}');
    }
}

if (!class_exists('JViewLegacy')) {
  class_alias('JView', 'JViewLegacy');
} 

class UAMViewUAM extends JViewLegacy {

	function display($tpl = null) {
		$mainframe = JFactory::getApplication();
		$params = $mainframe->getParams('com_uam');
		$user = JFactory::getUser();
		$uri = JFactory::getURI();

		// Require the com_content helper library
		//require_once(JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'icon.php');
		require_once(JPATH_SITE.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_content'.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'route.php');
		
		//load stylesheet and javascript
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::base(true).'/components/com_uam/assets/css/style.css');
		$document->addScript(JURI::base(true).'/components/com_uam/assets/javascript/script.js');

		//total of columns to show
		$total_columns = 0;
		$total_columns += ($params->get('id_column')) ? 1 : 0;
		$total_columns += ($params->get('title_column')) ? 1 : 0;
		$total_columns += ($params->get('published_column')) ? 1 : 0;
		$total_columns += ($params->get('featured_column')) ? 1 : 0;
		$total_columns += ($params->get('category_column')) ? 1 : 0;
		$total_columns += ($params->get('author_column')) ? 1 : 0;
		$total_columns += ($params->get('created_date_column')) ? 1 : 0;
		$total_columns += ($params->get('start_publishing_column')) ? 1 : 0;
		$total_columns += ($params->get('finish_publishing_column')) ? 1 : 0;
		$total_columns += ($params->get('hits_column')) ? 1 : 0;
		$total_columns += ($params->get('edit_alias_column')) ? 1 : 0;
		$total_columns += ($params->get('copy_column')) ? 1 : 0;
		$total_columns += ($params->get('edit_column')) ? 1 : 0;
		$total_columns += ($params->get('trash_column')) ? 1 : 0;

		// Get data from the model
		$itens = $this->get('Data');
		$total = $this->get('Total');
		$pagination = $this->get('Pagination');
		$access = new stdClass();
		$canEditOwnOnly = $this->_canEditOwnOnly();

		$lists = $this->_getLists();

		$this->assign('action', str_replace('&', '&amp;', $uri->toString()));
		$this->assignRef('params', $params);
		$this->assignRef('total_columns', $total_columns);
		$this->assignRef('itens', $itens);
		$this->assignRef('lists', $lists);
		$this->assignRef('access', $access);
		$this->assignRef('pagination', $pagination);
		$this->assignRef('user', $user);
		$this->assignRef('canEditOwnOnly', $canEditOwnOnly);

		parent::display($tpl);
	}
	
	
	function &getItem($index = 0, &$params) {
		$item =& $this->itens[$index];
		$item->text = $item->introtext;

		// Get the page/component configuration and article parameters
		$item->params = clone($params);
		if (class_exists('JRegistry')) {
			$aparams = new JRegistry();
			$aparams->loadString($item->attribs); // this should be json

		} else {
			$aparams = new JParameter($item->attribs);
		}

		// Merge article parameters into the page configuration
		$item->params->merge($aparams);

		return $item;
	}

	function _canEditOwnOnly() {
		
		// get list of categories and check edit capability;
		
		$c = JHtml::_('category.options', 'com_content');
		
		// Remove those categories the user can't see
		$user = JFactory::getUser();
		foreach($c as $i => $option)
		{
			if ($user->authorise('core.edit', 'com_content.category.'.$option->value) == true ) {
				return false;
				break;
			}
		}
		return true;
	}
	
	function _getLists() {
		$mainframe =  JFactory::getApplication();
		$params = $mainframe->getParams('com_uam');
		$option = JRequest::getCMD('option'); 
		
		// Initialize variables
		$db = JFactory::getDBO();

		// Get some variables from the request
		$sectionid = JRequest::getVar( 'sectionid', -1, '', 'int' );
		$redirect = $sectionid;
		$filter_order = $mainframe->getUserStateFromRequest($option.'filter_order', 'filter_order', 'c.id', 'cmd');
		$filter_order_Dir = $mainframe->getUserStateFromRequest($option.'filter_order_Dir', 'filter_order_Dir', '', 'word');
		$filter_state = $mainframe->getUserStateFromRequest($option.'filter_state', 'filter_state', '', 'word');
		$filter_catid = $mainframe->getUserStateFromRequest($option.'filter_catid', 'filter_catid', -1, 'int');
		$filter_langid = $mainframe->getUserStateFromRequest($option.'filter_langid', 'filter_langid', '', 'string');
		$filter_authorid = $mainframe->getUserStateFromRequest($option.'filter_authorid', 'filter_authorid', 0, 'int');
		$search = $mainframe->getUserStateFromRequest($option.'filter_search', 'filter_search', '', 'string');
		$search = JString::strtolower($search);

		if ($params->get('useallcategories') == 1) {
			// get list of categories for dropdown filter
			$c = JHtml::_('category.options', 'com_content');
		}
		else {
			$query = "SELECT a.id as value, a.title as text FROM #__categories AS a WHERE a.parent_id > 0 AND
						extension = 'com_content' AND
						a.published = 1 AND
						a.lft >= (SELECT b.lft FROM #__categories b WHERE b.id = ".$params->get('mycategory'). ") AND
						a.rgt <= (SELECT c.rgt FROM #__categories c WHERE c.id = ".$params->get('mycategory'). ")";
						
			$db =  JFactory::getDBO();
			$db->setQuery($query);
			$c = $db->loadObjectList();					
		}
		
		// Remove those categories the user can't see
		$user = JFactory::getUser();
		foreach($c as $i => $option)
		{
			// To take save or create in a category you need to have create rights for that category
			// unless the item is already in that category.
			// Unset the option if the user isn't authorised for it. In this field assets are always categories.
			if ($user->authorise('core.create', 'com_content.category.'.$option->value) != true ) {
				unset($c[$i]);
			}		
		}
		
		$cats[] = JHtml::_('select.option', '0', '- '.JText::_('COM_UAM_SELECT_CATEGORY').' -', 'value', 'text');
		$cats = array_merge($cats, $c);
		$lists['catid'] = JHTML::_('select.genericlist',  $cats, 'filter_catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $filter_catid);
		$lists['filter_catid'] = $filter_catid;

		// get list of Authors for dropdown filter

		if (isset($l))
			unset($l);
		
		if (count($c) > 0) {
			$l = '';
			// Convert into "(id1, id2...)" for the query
			foreach (array_values($c) as $k)
				// $k is a JObject with ->value = category id
				$l .= $k->value .', ';
			$l = '(' . strrev(substr(strrev($l), 2)) . ')';
		}

		$query = 'SELECT c.created_by, u.name' .
				' FROM #__content AS c' .
				' LEFT JOIN #__users AS u ON u.id = c.created_by' .
				' WHERE (c.state <> -1' .
				' AND c.state <> -2)';

		if($filter_catid > 0) {
			$query .= ' AND (c.catid = '.$db->Quote($filter_catid) . ')';
		}
		else if (isset($l)) {
			$query .= ' AND (c.catid in ' . $l . ')';
		}
		else $query .= ' AND 0';	// Can't see any categories so can't see any authors
				
		$query .= ' GROUP BY u.name ORDER BY u.name';
		
		$authors[] = JHTML::_('select.option', '0', '- '.JText::_('COM_UAM_SELECT_AUTHOR').' -', 'created_by', 'name');
		$db->setQuery($query);
		$authors = array_merge($authors, $db->loadObjectList());
		$lists['authorid'] = JHTML::_('select.genericlist',  $authors, 'filter_authorid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'created_by', 'name', $filter_authorid);

		// table ordering
		$lists['order_Dir'] = $filter_order_Dir;
		$lists['order'] = $filter_order;

		// search filter
		$lists['filter_search'] = $search;

		// state filter
		$states = array();
		$states[] = JHTML::_('select.option', '', JText::_('JOPTION_SELECT_PUBLISHED'), 'value', 'text');
		$states[] = JHTML::_('select.option', 'P', JText::_('JPUBLISHED'), 'value', 'text');
		$states[] = JHTML::_('select.option', 'U', JText::_('JUNPUBLISHED'), 'value', 'text');
		$lists['state'] = JHTML::_('select.genericlist',  $states, 'filter_state', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $filter_state);

		$l = JHtml::_('contentlanguage.existing', true, true);
		$langs[] = JHtml::_('select.option', '', JText::_('JOPTION_SELECT_LANGUAGE'), 'value', 'text');
		$langs = array_merge($langs, $l);
		$lists['langs'] = JHTML::_('select.genericlist',  $langs, 'filter_langid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $filter_langid);

		return $lists;
	}

	function filterCategory($query, $active = NULL) {
		// Initialize variables
		$db =  JFactory::getDBO();

		$categories[] = JHTML::_('select.option', '0', '- '.JText::_('COM_UAM_SELECT_CATEGORY').' -');
		$db->setQuery($query);

		$categories = array_merge($categories, $db->loadObjectList());

		$category = JHTML::_('select.genericlist',  $categories, 'filter_catid', 'class="inputbox" size="1" onchange="document.adminForm.submit( );"', 'value', 'text', $active);

		return $category;
	}


	function getEditIcon($article, $params, $access, $attribs = array()) {
		$user = JFactory::getUser();
		$uri = JFactory::getURI();
		$ret = $uri->toString();

		if ($params->get('popup')) {
			return;
		}

		if ($article->state < 0) {
			return;
		}


		JHTML::_('behavior.tooltip');

		// Show checked_out icon if the article is checked out by a different user
		if ($article->checked_out > 0 && $article->checked_out != $user->get('id')) {
			$checkoutUser = JFactory::getUser($article->checked_out);
//			$button = JHTML::_('image','system/checked_out.png', NULL, NULL, true);
			$button = "<img src='" . $this->baseurl . "/components/com_uam/assets/images/" . $this->params->get('iconset') . "/checked_out.png' />";
			$date = JHTML::_('date',$article->checked_out_time);
			$tooltip = JText::_('JLIB_HTML_CHECKED_OUT').' :: '.$checkoutUser->name.' <br /> '.$date;
			return '<span class="hasTip" title="'.htmlspecialchars($tooltip, ENT_COMPAT, 'UTF-8').'">'.$button.'</span>';
		}		

		if ($article->state == 0) {
			$overlib = JText::_('COM_UAM_TOOLTIP_UNPUBLISHED');
		} else {
			$overlib = JText::_('COM_UAM_TOOLTIP_PUBLISHED');
		}
		$date = JHTML::_('date', $article->created);
		$author = $article->created_by_alias ? $article->created_by_alias : $article->author;

		$overlib .= '&lt;br /&gt;';
		$overlib .= JText::_($article->groups);
		$overlib .= '&lt;br /&gt;';
		$overlib .= $date;
		$overlib .= '&lt;br /&gt;';
		$overlib .= htmlspecialchars($author, ENT_COMPAT, 'UTF-8');

        // if canedit OR if own article in ubliblished state

        if ( ($access->canEdit) ||
            ( $params->get('user_can_editpublished') && ($access->canEdit || ($access->canEditOwn && ($article->created_by == $user->get('id')))) ||
            ( !$params->get('user_can_editpublished') && $article->state != 1 && $access->canEditOwn && ($article->created_by == $user->get('id'))))) {
		//if ($access->canEdit || ($access->canEditOwn && $article->created_by == $user->get('id'))) {
			$app = JFactory::getApplication();
			$menuid =  $app->getMenu()->getActive()->id;
            if ($params->get('utf8_url_fix') ) {
                $url = 'index.php?option=com_content&task=article.edit&a_id='.$article->id.'&Itemid='.$menuid.'&return='.base64_encode(urlencode($ret));
            } else {
                $url = 'index.php?option=com_content&task=article.edit&a_id='.$article->id.'&Itemid='.$menuid.'&return='.base64_encode($ret);
            }
			$icon = $article->state ? 'ico_edit.png' : 'ico_edit_unpublished.png';
//			$text = JHTML::_('image.site', $icon, '/components/com_uam/assets/images/' . $params->get('iconset') . '/', NULL, NULL, JText::_('COM_UAM_EDIT'));
			$text = "<img src='" . $this->baseurl . "/components/com_uam/assets/images/" . $this->params->get('iconset') . "/" . $icon . "' />";
			$button = JHTML::_('link', JRoute::_($url), $text);
			$output = '<span class="hasTip" title="'.JText::_( 'COM_UAM_EDIT' ).' :: '.$overlib.'">'.$button.'</span>';
		}
		else {
			$icon = 'bw_ico_edit.png';
//			$text = JHTML::_('image.site', $icon, '/components/com_uam/assets/images/' . $params->get('iconset') . '/', NULL, NULL, JText::_('COM_UAM_EDIT'));
			$text = "<img src='" . $this->baseurl . "/components/com_uam/assets/images/" . $this->params->get('iconset') . "/" . $icon . "' />";
			$output = '<span class="hasTip" title="'.JText::_( 'COM_UAM_EDIT' ).' :: '.$overlib.'">'.$text.'</span>';	
		}
		return $output;
	}

	function getPublishedIcon($article, $params, $access, $attribs = array()) {
		$user = JFactory::getUser();
		$uri = JFactory::getURI();
		$ret = $uri->toString();

		$override = false;

		if(($access->canEdit || $access->canEditOwn) && $params->get('user_can_publish'))
		{
			$override = true;
		}

		// Special state for dates
		if ($article->publish_up || $article->publish_down)
		{
			$nullDate   = JFActory::getDBO()->getNullDate();
			$nowDate    = JFactory::getDate()->toUnix();

			$tz = JFactory::getApplication()->getCfg('offset');

			$publish_up     = ($article->publish_up      != $nullDate) ? JFactory::getDate($article->publish_up, $tz)     : false;
			$publish_down   = ($article->publish_down    != $nullDate) ? JFactory::getDate($article->publish_down, $tz)   : false;

			if ($article->state == 1) {
				if ($publish_up && $nowDate < $publish_up->toUnix()) {
					$alt = JText::_('JLIB_HTML_PUBLISHED_PENDING_ITEM');
					$img = "ico_publish_y.png";
				}
				else if ($publish_down && $nowDate > $publish_down->toUnix()) {
					$alt = JText::_('JLIB_HTML_PUBLISHED_EXPIRED_ITEM');
					$img = "ico_publish_r.png";
				}
				else {
					$img = "ico_publish_g.png";
					$alt = JText::_('COM_UAM_PUBLISHED');
				}
			}
			else {
					$img = "ico_publish_x.png";
					$alt = JText::_('COM_UAM_UNPUBLISHED');
			}
		}
		else {

			$img = ($article->state > 0) ? "ico_publish_g.png" : "ico_publish_x.png";
			$alt = ($article->state > 0) ? JText::_('COM_UAM_PUBLISHED') : JText::_('COM_UAM_UNPUBLISHED');
		}
		
		if(($access->canPublish && $article->state != -2) || ($user->id == $article->created_by && $override)) {
			$img = $this->baseurl . "/components/com_uam/assets/images/" . $this->params->get('iconset') . "/" . $img;		
			$url = "index.php?option=com_uam&view=uam&task=unPublish&cid={$article->id}&Itemid=" . JRequest::getInt('Itemid');
			$link = JRoute::_($url);
			$output = "<a href='$link'>";
			$output .= "<img src='$img' alt='$alt' title='$alt' />";
			$output .= '</a>';
		}
		else {
			$img = $this->baseurl . "/components/com_uam/assets/images/" . $this->params->get('iconset') . "/bw_" . $img;
			$output = "<img src='$img' alt='$alt' title='$alt' />";
		}
		return $output;

	}
	
	function getTitle($article, $params, $access, $attribs = array()) {
		$title = htmlentities($article->introtext . $article->fulltext, ENT_COMPAT, "UTF-8");
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($article->id, $article->catslug));
		$linked = false;
		// Special state for dates
		if ($article->publish_up || $article->publish_down)
		{
			$nullDate   = JFActory::getDBO()->getNullDate();
			$nowDate    = JFactory::getDate()->toUnix();

			$tz = JFactory::getApplication()->getCfg('offset');

			$publish_up     = ($article->publish_up      != $nullDate) ? JFactory::getDate($article->publish_up, $tz)     : false;
			$publish_down   = ($article->publish_down    != $nullDate) ? JFactory::getDate($article->publish_down, $tz)   : false;

			if ($article->state == 1) {
				if ($publish_up && $nowDate < $publish_up->toUnix()) {
					$linked = false;
				}
				else if ($publish_down && $nowDate > $publish_down->toUnix()) {
					$linked = false;
				}
				else {
					$linked = true;
				}
			}
			else {
					$linked = false;
			}
		}
		else {
			$linked = ($article->state > 0) ? true : false;
		}
		
		/* Link setting is overridden by backend or menu options */
		$linked = $params->get('title_link');
			
		
		if ($params->get('show_content')) {
			if($linked) {
				echo '<span class="hasTip" title="'.JText::_( $article->title ).' :: ' . $title . '"><a href=' . $link . '>' . $article->title . '</a></span>';
			}
			else {
				echo '<span class="hasTip" title="'.JText::_( $article->title ).' :: ' . $title . '">' . $article->title . '</span>';
			}
		}
		else {
			if($linked > 0) {
				echo '<a href=' . $link . '>' . $article->title . '</a>';
			}
			else {
				echo $article->title;
			}
		}
	}
}
?>
