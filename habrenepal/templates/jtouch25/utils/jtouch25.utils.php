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

/**
 * Utils for Jtouch25 template
 */
class Jtouch25Utils extends JObject {
	public static $tpl = null;
	
	/**
	 * Auto detect for built in supported extensions and load their required stuffs on mobile
	 */
	public static function extraExtensionInit($tplParams){
		$document = JFactory::getDocument();
		$tplURL = JURI::base() .'templates/jtouch25';
		
		$component = JRequest::getVar('option', '');

		// VirtueMart (since 2.0.11)
		if( (int)$tplParams->get('jtouch-virtuemart-mobile-layout', 0) == 1 ){
			// Unset some native scripts
			require_once JPATH_ROOT.'/administrator/components/com_virtuemart/helpers/config.php';
			foreach ($document->_scripts as $key => $value){
				if(! (strpos($key, 'googleapis.com/ajax/libs/jquery') === false) ){
					unset($document->_scripts[$key]);
				}
			}
			/*
			unset($document->_scripts['//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js']);
			unset($document->_scripts['//ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js']);
			unset($document->_scripts['//ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js']);
			*/
			//unset($document->_scripts[vmJsApi::setPath('jquery', false, '', true, 'js')]);
			unset($document->_scripts[vmJsApi::setPath('vmprices', false, '', NULL, 'js')]);
			
			// Add more
			$document->addStyleSheet( $tplURL.'/html/com_virtuemart/assets/css/jtouch-vm2.css', 'jtouch.cssfile');
			if(file_exists(JPATH_ROOT.DS.'templates'.DS.'jtouch25'.DS.'html'.DS.'com_virtuemart'.DS.'assets'.DS.'css'.DS.'jtouch-vm2-customize.css')){
				$document->addStyleSheet( $tplURL.'/html/com_virtuemart/assets/css/jtouch-vm2-customize.css', 'jtouch.cssfile');
			}
			
			$document->addScript($tplURL.'/html/com_virtuemart/assets/js/vmprices.js', 'jtouch.jsfile');
			$document->addScript($tplURL.'/html/com_virtuemart/assets/js/jtouch-vm2.js', 'jtouch.jsfile');
		}
	}
	
	
	/**
	 * Write all js code to the template,
	 * those must have stype = jtouch.jscode or jtouch.jsfile
	 */
	public static function writeJs($tplParams=null){
		$document = JFactory::getDocument();

		if($tplParams != null){
			echo "\n <!-- ReCaptcha Settings -->";
			if( (int)$tplParams->get('jtouch-google-captcha-enable', '1') == 1 ){
				$pubkey = $tplParams->get('jtouch-google-captcha-publickey', '') ;
				$server = 'http://api.recaptcha.net/js/recaptcha_ajax.js';
				/*
				if (JBrowser::getInstance()->isSSLConnection()) {
					$server = 'https://www.google.com/recaptcha/api/js/recaptcha_ajax.js';
				}*/
				echo "\n".'<script src="'.$server.'" type="text/javascript"></script>'."\n";
				echo "<script type='text/javascript'> 
						(function($){
							$('[data-role=page]').on('pageshow', function (event, ui) {
						    	try {
						    		if( $('#dynamic_recaptcha_1').length > 0 ){
						    			Recaptcha.create('{$pubkey}', 'dynamic_recaptcha_1', {theme: 'white'});
						    		}
								}
						    	catch(err){}
						    });
					    })(jQuery);
					 </script> "
				;
			}	
		}
	}
	
	
	/**
	 * Load stuffs for Virtuemart 2 (less than 2.0.11)
	 * @param String $assetPath path to VM 2 assets folder (built in Jtouch, not VM's default)
	 */
	public static function vmLoadJsFiles($assetPath, $minfile){
		$document = JFactory::getDocument();
		
		$lang = JFactory::getLanguage();
		$lang->load('com_virtuemart');

		// Main Jtouch css for VM 2
		$document->addStyleSheet($assetPath.'/css/jtouch-virtuemart'.$minfile.'.css', 'jtouch.cssfile');
		$document->addStyleSheet($assetPath.'/css/jtouch-virtuemart-query'.$minfile.'.css', 'jtouch.cssfile');
		
		//jSite()
		$document->addScript($assetPath.'/js/vmsite'.$minfile.'.js', 'jtouch.jsfile');
		
		//jPrice()
		
		$jsVars  = "\n var siteurl = '". JURI::base( ) ."' ;\n" ;
		$jsVars .= " var vmCartText = '". addslashes( JText::_('COM_VIRTUEMART_MINICART_ADDED_JS') )."' ;\n" ;
		$jsVars .= " var vmCartError = '". addslashes( JText::_('COM_VIRTUEMART_MINICART_ERROR_JS') )."' ;\n" ;
		$jsVars .= " var vmCartPopupHeader = '". addslashes( JText::_('JTOUCH25_VM_CART_POPUP_HEADER') )."' ;\n" ;
		$jsVars .= " var vmCartPopupOK = '". addslashes( JText::_('JTOUCH25_VM_CART_POPUP_OK') )."' ;\n" ;
		$jsVars .= " var vmCartPopupViewCart = '". addslashes( JText::_('JTOUCH25_VM_CART_POPUP_VIEWCART') )."' ;\n" ;
		$document->addScriptDeclaration($jsVars, 'jtouch.jscode');
		
		$document->addScript($assetPath.'/js/vmprices.jtouch'.$minfile.'.js', 'jtouch.jsfile');
	}
	
	
	/**
	 * Load stuffs for Kunena 1.7 forum
	 * @param String $assetPath path to kunena assets folder (built in Jtouch, not Kunena's default)
	 */
	public static function kunenaLoadJsFiles($minfile){
		$document = JFactory::getDocument();
		
		$lang = JFactory::getLanguage();
		$lang->load('com_kunena');

		// Main Jtouch css for Kunena
		$document->addStyleSheet('components/com_kunena/template/jtouch25kunena/css/kunena'.$minfile.'.css', 'jtouch.cssfile');
		$document->addStyleSheet('components/com_kunena/template/jtouch25kunena/css/kunena-query'.$minfile.'.css', 'jtouch.cssfile');
		
		//jSite()
		$document->addScript('components/com_kunena/template/jtouch25kunena/js/kunena'.$minfile.'.js', 'jtouch.jsfile');
	}
	
	
	/**
	 * Get details of Jtouch25 template, useful for get info about template params
	 */
	public static function getJtouchTemplate(){
		if (!self::$tpl) {
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('id, template, params');
			$query->from('`#__template_styles`');
			$query->where('`client_id` = 0 AND `template` LIKE \'jtouch25\' ');
			$query->order('`id` ASC');
			$db->setQuery( $query );
			self::$tpl = $db->loadObject();
		}
		return self::$tpl;  		
  	}

}