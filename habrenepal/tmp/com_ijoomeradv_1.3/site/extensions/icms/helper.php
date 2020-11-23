<?php
/*--------------------------------------------------------------------------------
# com_ijoomeradv_1.3 - iJoomer Advanced
# ------------------------------------------------------------------------
# author Tailored Solutions - ijoomer.com
# copyright Copyright (C) 2010 Tailored Solutions. All rights reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.ijoomer.com
# Technical Support: Forum - http://www.ijoomer.com/Forum/
----------------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class icms_helper {
	
	private $db_helper;
	
	function __construct(){
		$this->db_helper =& JFactory::getDBO();
	}
	
	function getCategoryList() {
		require_once JPATH_ADMINISTRATOR.'/components/com_categories/models/categories.php';
		$class = new CategoriesModelCategories();
		$query = $class->getListQuery();

		$this->db_helper->setQuery($query);
		$result = $this->db_helper->loadObjectList();
		return $result; 
	}
}
