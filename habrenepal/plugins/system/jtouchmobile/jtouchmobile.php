<?php
/**
 * @package 	Jtouch.Plugin
 * @author		Nguyen Mobile
 * @copyright	Copyright (C) 2011 - 2013 JTouchMobile.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class  plgSystemJtouchmobile extends JPlugin {
	private $caching = 0;
	
	/**
	 * For caching object
	 * @var Object
	 */
	private $_cache = null;
	
	function __construct(& $subject, $config){
		parent::__construct($subject, $config);
		$config = JFactory::getConfig();
		
		//Set the language in the class
		$options = array(
				'defaultgroup'	=> 'page',
				'browsercache'	=> $this->params->get('browsercache', false),
				'caching'		=> false,
		);

		$this->_cache = JCache::getInstance('page', $options);
	}
	
	
	/**
	 * Hook to app process, after initialized
	 */
	public function onAfterInitialise(){
		
		$app = &JFactory::getApplication();
		if ($app->isAdmin()) {
			// Request from Jtouch25 tpl page?
			$isClearJtCoreCache = (JRequest::getInt('jtclearcache', 0) == 1)? true : false;
			$isSilent = false;
			// Or on Saving Jtouch25 template
			if(!$isClearJtCoreCache){
				$option = 	JRequest::getVar('option', '');
				if($option == 'com_templates'){
					$jForm = JRequest::getVar('jform', null);
					if($jForm != null && $jForm['template'] == 'jtouch25'){
						$isClearJtCoreCache = true;
						$isSilent = true;
					}
				}
			}
			
			// Clear cache - request from backend. After JTouch tpl setting saved
			if($isClearJtCoreCache){
				jimport( 'joomla.application.component.model');
				JModel::addIncludePath (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_cache' . DS . 'models');
				$cacheModel =& JModel::getInstance('cache', 'cacheModel');
				$cacheModel->clean('jtouch25');
				$cacheModel =& JModel::getInstance('cache', 'cacheModel');
				$cacheModel->cleanlist(array('page', 'jtouch25page') );
				if(!$isSilent) jexit('The JTouchMobile Cache was deleted!');
			}
			
			// When we have a new menu item added/modified/redoderring? Clear page cache!
			$isClearPageCache = false;
			$option = JRequest::getVar('option', '');
			$task = JRequest::getVar('task', '');
			if($option == 'com_menus' || $option = 'com_content'){
				
				if( !(strpos($task, 'save') === false) || !(strpos($task, 'apply') === false) || !(strpos($task, 'order')=== false) ){
					$isClearPageCache = true;
				} 
			}
			//jexit("Clear man! option = {$option} | task = {$task}");
			if($isClearPageCache){
				jimport( 'joomla.application.component.model');
				JModel::addIncludePath (JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_cache' . DS . 'models');
				$cacheModel =& JModel::getInstance('cache', 'cacheModel');
				$cacheModel->cleanlist(array('page', 'jtouch25page') );
			}
		}else{
			/*We are on Site app. Do some initial here*/
			$this->detectJtouch();
			
			$this->cache_OnAfterInitialise();
		}
	}
	
	
	/**
	 * Detect and change the default front end template to JTouch if should be
	 */
	private  function detectJtouch() {
    	$app = &JFactory::getApplication();

	    if ($app->isAdmin()) {
	      return;
	    }
	    
	    $enabledJts = (int)$this->params->get('jtouch_mobile_switch_enabled', 0);
	    
	    // Check for change to desktop template request
	    // If request come from url?
	  	$changeTplRequest = JRequest::getInt('jtpl', -1);
	  	$doChangeReq = false;
		if($changeTplRequest < 1){
			// Check current user session
			$changeTplRequest = $app->getUserStateFromRequest('jtpl', 'jtpl', -1, 'int');
			if($changeTplRequest > 0){
				$doChangeReq = true;
			}else if($changeTplRequest == 0){
				// Forged to default template? Continue of using that tpl!
				JRequest::setVar('force', 0);
				$doChangeReq = true;
			}else{
				// Check cookie?
				jimport('joomla.utilities.utility');
				$hash = JApplication::getHash('JTOUCHPLUGIN_JTPL');
				$changeTplRequest = JRequest::getInt($hash, 0, 'cookie', JREQUEST_ALLOWRAW | JREQUEST_NOTRIM);
				if($changeTplRequest > 0){
					$doChangeReq = true;
				}
			}
		}else{
			$doChangeReq = true;
		}
		
		$tpl = false;
		$forgeJtouch = -1;
		if($doChangeReq){
			// Apply this change tpl request
			$forgeJtouch = JRequest::getInt('force', -1);
			if($forgeJtouch == 1 || $forgeJtouch == 2){
				$tpl = $this->_getTplFromDataByName('jtouch25');
			}else if($forgeJtouch == 0){
				// oh, you want to switch to default template
				$tpl = false;
				// Remove cookie + session
				$config = JFactory::getConfig();
				$cookie_domain = $config->get('cookie_domain', '');
				$cookie_path = $config->get('cookie_path', '/');
				$lifetime = time() + 365 * 24 * 60 * 60;
				setcookie(
					JApplication::getHash('JTOUCHPLUGIN_JTPL'), -1, $lifetime, $cookie_path, $cookie_domain
				);
				$app->setUserState('jtpl', 0);
			}else{
				$tpl = $this->_getTplFromDataById($changeTplRequest);
			}
			
		}else{
			// If we have enable mobile detect function? Detect if users are browsing from a mobile device!
		    if ($enabledJts == 1) {
		    	$isMobile = self::isMobileRequest();
		      	if ( $isMobile) {
		        	$mobileTpl = $this->params->get('jtouch_mobile_template', 'jtouch25');
		        	$tpl = $this->_getTplFromDataByName($mobileTpl);
		      	}
		    }
		}
		
		// We have new template to apply
		if($tpl != false){
			// Apply this template
			$this->_setTemplate( $tpl->template );
			$app->getTemplate(true)->params = new JRegistry($tpl->params);
			
			// Save to cookie. Do not save if param is index.php?jtpl=1&force=2 (is temporary force current page to mobile)
			if($forgeJtouch != 2){
				$app->setUserState('jtpl', $tpl->id);
				
				$config = JFactory::getConfig();
				$cookie_domain = $config->get('cookie_domain', '');
				$cookie_path = $config->get('cookie_path', '/');
				$lifetime = time() + 365 * 24 * 60 * 60;
				setcookie(
					JApplication::getHash('JTOUCHPLUGIN_JTPL'), $tpl->id, $lifetime, $cookie_path, $cookie_domain
				);
			}
		}
		return;
		
		// If we are using Jtouch25?
		if($app->getTemplate() == 'jtouch25'){
			
		} else{
			// This is not Jtouch25 environment? Return back original settings
			// ...Default Caching
			//JFactory::getConfig()->setValue('config.caching', $this->caching);
		}
	}
	
	
	public function onAfterRoute(){
		$this->redirectMobileHome();
	}
	
	
	private function redirectMobileHome(){
		$app = &JFactory::getApplication();
		
		if ($app->isAdmin()) {
			return false;
		}
		if(JRequest::getInt('jtrnoredirect', 0) == 1) return false;
		
		if($app->getTemplate() == 'jtouch25'){
			//Redirect to default page of mobile view?
			$newMobileHome = (int)$this->params->get('jtouch_default_mobile_menu', 0);
			if($newMobileHome < 1) return false;
			$mobileHomeId = (int)$this->params->get('jtouch_default_mobile_menu_item', 0);
			if($mobileHomeId < 1) return false;
			
			$menu = $app->getMenu();
			if($menu == null) return false;
			$currentId = 0;
			$currentActive = $menu->getActive();
			if($currentActive == null){ 
				$currentId = JRequest::getInt('Itemid', 0);
			}else{
				$currentId = $currentActive->id;
			}
			$lang =& JFactory::getLanguage();
			$desktopDefaultId  = $menu->getDefault($lang->getTag())->id;
			
		
			if( ($desktopDefaultId == $currentId) && ($mobileHomeId != $desktopDefaultId) ){
				$url = clone JFactory::getURI();
				$defaultMobileUrl = $url->base().'index.php?Itemid='.$mobileHomeId.'&jtrnoredirect=1';
				
				$item = $menu->getItem($mobileHomeId);
				$item->flink = $item->link;
				// Reverted back for CMS version 2.5.6
				switch ($item->type)
				{
					case 'separator':
						// No further action needed.
						continue;
				
					case 'url':
						if ((strpos($item->link, 'index.php?') === 0) && (strpos($item->link, 'Itemid=') === false)) {
							// If this is an internal Joomla link, ensure the Itemid is set.
							$item->flink = $item->link.'&Itemid='.$item->id;
						}
						break;
				
					case 'alias':
						// If this is an alias use the item id stored in the parameters to make the link.
						$item->flink = 'index.php?Itemid='.$item->params->get('aliasoptions');
						break;
				
					default:
						$router = JSite::getRouter();
						if ($router->getMode() == JROUTER_MODE_SEF) {
							$item->flink = 'index.php?Itemid='.$item->id;
						}
						else {
							$item->flink .= '&Itemid='.$item->id;
						}
						break;
				}
				$item->flink = $item->flink.'&jtrnoredirect=1';
				if (strcasecmp(substr($item->flink, 0, 4), 'http') && (strpos($item->flink, 'index.php?') !== false)) {
					$item->flink = JRoute::_($item->flink, true, $item->params->get('secure'));
				}
				else {
					$item->flink = JRoute::_($item->flink);
				}
				
				// Using header redirect
				header("Cache-Control: no-cache");
				header("Pragma: no-cache");
				header("Location: $item->flink");
				jexit();
			}
		}
		// No redirect
		return false;
	}
	
	
	/**
	 * Hook to the compiler, remove mootools and other scripts
	 * change jtouch scripts to defaults
	 */
	public function onBeforeCompileHead() {
		$app = &JFactory::getApplication();

	    if ($app->isAdmin()) {
	      return;
	    }
	    
		if($app->getTemplate() != 'jtouch25'){
			return;
		}
		$document = JFactory::getDocument();
		//Looking for scripts
		$headers = $document->getHeadData();
		
		$isOnlyJtouch = ( (int)$this->params->get('jtouch_mobile_head_off', 0) == 1 )? true: false;
		$scripts = isset($headers['scripts']) ? $headers['scripts'] : array();
		$headers['scripts'] = array();
		
		// Change jtouch.jsfile to script file. And may also remove default js cmd files
		foreach($scripts as $url=>$type) {
			if($type['mime'] == 'jtouch.jsfile'){
				$type['mime'] = 'text/javascript';
				$headers['scripts'][$url] = $type;
			}else {
				// Also add Joomla default script files to header section?
				if(!$isOnlyJtouch){
					$headers['scripts'][$url] = $type;
				}
			}
		}
		
		// ... for js code
		if($isOnlyJtouch){
			$headers['script']['text/javascript'] = '';
			if( isset($headers['script']['jtouch.jscode']) ){
				$headers['script']['text/javascript'] = $headers['script']['jtouch.jscode'];
				unset($headers['script']['jtouch.jscode']);	
			}
		}else{
			if( isset($headers['script']['jtouch.jscode']) ){
				$headers['script']['text/javascript'] = (isset($headers['script']['text/javascript']))? $headers['script']['text/javascript'] : '';
				$headers['script']['text/javascript'] .= "\n\r\n\r" . $headers['script']['jtouch.jscode'];
				unset($headers['script']['jtouch.jscode']);
			}
		}
		
		// Change jtouch.cssfile cmd to css cmd, and also remove default css cmd 
		$css = isset($headers['styleSheets']) ? $headers['styleSheets'] : array();
		$headers['styleSheets'] = array();
		foreach($css as $url=>$type) {
			if($type['mime'] == 'jtouch.cssfile'){
				$type['mime'] = 'text/css';
				$headers['styleSheets'][$url] = $type;
			}else if(!$isOnlyJtouch){
				$headers['styleSheets'][$url] = $type;
			}
		}
		
		// ... for css code
		if($isOnlyJtouch){
			$headers['style']['text/css'] = '';
			if( isset($headers['style']['jtouch.csscode']) ){
				$headers['style']['text/css'] = $headers['style']['jtouch.csscode'];
				unset($headers['style']['jtouch.csscode']);	
			}
		}else{
			if( isset($headers['style']['jtouch.csscode']) ){
				if(!isset($headers['style']['text/css'])) $headers['style']['text/css'] = '';
				$headers['style']['text/css'] .= "\n\r\n\r" . $headers['style']['jtouch.csscode'];
				unset($headers['style']['jtouch.csscode']);
			}
		}
		//die(var_dump($headers));
			
		// Using Jtouch code + native code? Remove Mootools
		if(!$isOnlyJtouch){
			// Requires mootools removed?
			if( (int)$this->params->get('jtouch_mobile_remove_mootools', 0) == 1){
				$scripts = isset($headers['scripts']) ? $headers['scripts'] : array();
				//	cleare the original scripts
				$headers['scripts'] = array();
				//	deleting mootols...
				
				foreach($scripts as $url=>$type) {
					if (strpos($url, 'mootools') === false && strpos($url, 'caption.js') === false && strpos($url, 'js/core.js') === false) {
						$headers['scripts'][$url] = $type;
					}
				}
				
				//destroy something likes function keepAlive() {
				$headers['script']['text/javascript']  = str_replace('window.addEvent', 'console.log', $headers['script']['text/javascript'] );
			}
		
		} else {
			// Remove custom code
			$custom = array();
			$custom[] = '   ';
			
			$headers['custom'] = $custom;
			//$headers['links'] = $custom;
		}
		
		//	set the new head data
		//var_dump($headers); die();
		$document->setHeadData($headers);
	}
	
	public function onAfterRender(){
		$this->cache_OnAfterRender();
	}
	
	
	/**
	 * Load cache separately for desktop and mobile version 
	 * Copy from Cache Control
	 */
	public function cache_OnAfterInitialise() {
		if((int)$this->params->get('jtouch_mobile_cache', 0) == 0) return;
		
		global $_PROFILER;
		$app	= JFactory::getApplication();
		$user	= JFactory::getUser();
	
	
		if ($app->isAdmin() || JDEBUG) {
			return;
		}
	
		if (count($app->getMessageQueue())) {
			return;
		}
		
		/* Nguyen > */
		// Should we redirect from default desktop page to default mobile page? If yes, no caching function here
		//$this->redirectMobileHome();
		
		// fix the notice: Undefined property: JSite::$registeredurlparams in /phpcenter/jtouch25/libraries/joomla/cache/cache.php on line 639
		if(empty($app->registeredurlparams)){
			$app->registeredurlparams = false;
		}
		
		$config = JFactory::getConfig();
		$cacheBase = $config->get('cache_path', JPATH_CACHE);
		if($app->getTemplate() == 'jtouch25'){
			$cacheBase .= '/jtouch25page';
			if( ! is_dir($cacheBase) ){
				mkdir($cacheBase, 0775);
			}
		}
		$options = array(
				'cachebase' 	=> $cacheBase,
				'defaultgroup'	=> 'page',
				'browsercache'	=> $this->params->get('jtouch_mobile_browsercache', false),
				'caching'		=> false,
		);
	
		$this->_cache = JCache::getInstance('page', $options);
		/* < Nguyen */
	
		if ($user->get('guest') && $_SERVER['REQUEST_METHOD'] == 'GET') {
			$this->_cache->setCaching(true);
		}
	
		$data  = $this->_cache->get();
	
		if ($data !== false) {
			JResponse::setBody($data);
	
			echo JResponse::toString($app->getCfg('gzip'));
	
			if (JDEBUG) {
				$_PROFILER->mark('afterCache');
				echo implode('', $_PROFILER->getBuffer());
			}
	
			$app->close();
		}
	}
	
	
	/**
	 * Store the content for caching
	 * Copy from Cache Control
	 */
	function cache_OnAfterRender(){
		if((int)$this->params->get('jtouch_mobile_cache', 0) == 0) return;
		
		$app = JFactory::getApplication();
	
		if ($app->isAdmin() || JDEBUG) {
			return;
		}
	
		if (count($app->getMessageQueue())) {
			return;
		}
	
		$user = JFactory::getUser();
		if ($user->get('guest')) {
			//We need to check again here, because auto-login plugins have not been fired before the first aid check
			$this->_cache->store();
		}
	}

	
	/**
	 * Check if users come from mobile devices or not
	 */
	public function isMobileRequest() {
    	$isMobile = false;
    	
    	if(!class_exists('uagent_info')){
    		require_once(JPATH_PLUGINS.DS."system".DS."jtouchmobile".DS."mdetect.php");
    	}
    	$ua = new uagent_info();
    	
    	/**
    	 * Update 28.Jun.2012 - Nguyen
    	 * define 'JTOUCHMOBILE_PLUGIN_ENVIRONMEN' with contain the name of environment: DESKTOP | TABLET | MOBILE
    	 * which can be useful for other extension without repeat the environment detect
    	 * Update 02.Sep.2012 - Nguyen
    	 * includes all mobile devices instead of just smartphone
    	 */
    	if($ua->DetectMobileQuick()){
    		define('JTOUCHMOBILE_PLUGIN_ENVIRONMENT', 'MOBILE');
    		$isMobile = true;
    	}
    	if ($ua->DetectTierTablet() ){
    		define('JTOUCHMOBILE_PLUGIN_ENVIRONMENT', 'TABLET');
    		$isMobile = true;
    	}
    	
    	if($isMobile == false){
    		define('JTOUCHMOBILE_PLUGIN_ENVIRONMENT', 'DESKTOP');
    	}
    	
    	if((int)$this->params->get('jtouch_mobile_include_tablets', 0) == 0){
    		if(JTOUCHMOBILE_PLUGIN_ENVIRONMENT =='TABLET' ){
    			$isMobile = false;
    		}	
    	}
    	    	
    	return $isMobile;
	}
	
	
	
	/**
	 * Get default menu ItemID 
	 * @return number
	 */
	public static function getDefaultPageId(){
		$defaultID = 0;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id');
		$query->from('#__menu');
		$query->where('home = 1');
		
		$db->setQuery( $query );
		$row = $db->loadObject();
		if($row){
			$defaultID = $row->id;
		}
		
		return $defaultID;
	}
	
	/**
	 * Cached function for getCachedDefaultPageId
	 */
	public function getCachedDefaultPageId() {
		$cache = & JFactory::getCache();
		$cache->setCaching( 1 );
	
		//$profiler = new JProfiler();
		return $cache->call( array( 'plgSystemJtouchmobile', 'getDefaultPageId' ) );
	}
	
	
	/**
	 * Get template info by provide its ID
	 * @param Integer $tplId
	 */
	private function _getTplFromDataById($tplId){
  		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, template, params');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `id`= '. (int)$tplId);
		$query->order('`id` ASC');
		$db->setQuery( $query );
		$row = $db->loadObject();
		if(!$row){
			return false;
		}else{
			return $row;
		}	
  	}
  	
  
  	/**
  	 * Get template info by provide its name
  	 * @param string $tplName
  	 */
	private function _getTplFromDataByName($tplName){
  		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, template, params');
		$query->from('`#__template_styles`');
		$query->where('`client_id` = 0 AND `template` LIKE \''.$tplName.'\' ');
		$query->order('`id` ASC');
		$db->setQuery( $query );
		$row = $db->loadObject();
		if(!$row){
			return false;
		}else{
			return $row;
		}	
  	}

  	
  	/**
  	 * Set template that apply to the whole system
  	 * @param object $tpl
  	 */
	protected function _setTemplate( $tpl = null) {
    	if (empty($tpl)) {
      		return;
	    } else {
	    	$app = &JFactory::getApplication();
	      	$app->setTemplate( $tpl);
	
	     	// For sh404SEF
	      	if (!defined('SHMOBILE_MOBILE_TEMPLATE_SWITCHED')) {
	        	define( 'SHMOBILE_MOBILE_TEMPLATE_SWITCHED', 1);
	      	}
	    }
	}
	
}
