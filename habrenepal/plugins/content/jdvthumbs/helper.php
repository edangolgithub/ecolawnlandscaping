<?php
/**
 * @license        GNU/GPL
 */
 
// no direct access
defined('_JEXEC') or die('Restricted access');

class jdvThumbsHelper
{

	function addScript( $file, $path, $noCache )
	{
		$document = & JFactory::getDocument();
		$curlang = $document->language;
		if ($curlang == 'ru-ru') {
			//$file = substr($file,0, strlen($file)-3).'-ru.js'; 
		} else { 
			
		}
		if($noCache) {
			JHTML::script( $file, $path );
		}else{
			echo '<script type="text/javascript" src="' . $path . '/' . $file . '"></script>' . "\n";
		}
	}
	
	
	function addCSS( $file, $path, $noCache )
	{
		if($noCache) {
			JHTML::stylesheet( $file, $path );
		}else{
			echo '<link rel="stylesheet" type="text/css" href="' . $path . '/' . $file . '" />' . "\n";
		}
	}
	
	
	function getItemsParams( $forItemid )
	{
		$array_items = array();
		$tmp = explode("\n", $forItemid);
		foreach ($tmp as $value){
			//$value = trim($value);
			$tmp2 = explode(':', $value);
			$itemid = str_replace(' ', '', strtolower($tmp2[0]));
			if (!array_key_exists ( 1 , $tmp2 )){
				$tmp2[1] = '';
			}
			$tmp2[1] = trim($tmp2[1]);
			$array_itemid = explode(' ', $tmp2[1]);
			
			$array_for_itemid = array();
			for ($i=0; $i<count($array_itemid); $i++){
				if (empty($array_itemid[$i])){
					return array();
				}
				
				switch ($i) {
				case 0:
					$array_for_itemid['width'] = trim($array_itemid[$i]);
					break;
					
				case 1:
					$array_for_itemid['height'] = trim($array_itemid[$i]);
					break;
					
				case 2:
					$array_for_itemid['sizeon'] = trim($array_itemid[$i]);
					break;
					
				case 3:
					$array_for_itemid['media'] = trim($array_itemid[$i]);
					break;
					
				default:
					$array_for_itemid[$i] = trim($array_itemid[$i]);
					break;
				}
			}
			
			foreach ($array_for_itemid as &$param){
				$param = trim($param);
			}
			$array_items[$itemid] = $array_for_itemid;
		}
		//print_r($array_items);
		return $array_items;
	}
	
	
	function getItemidParams( $Itemid, $params )
	{
	//echo $Itemid;
	
		$forItemid = $params->get( 'forItemid', '');
		
		$array_items = jdvThumbsHelper::getItemsParams( $forItemid );
		
		if (array_key_exists ( $Itemid , $array_items )){//print_r($array_items);
			return $array_items[$Itemid];
		}else{
			return array();
		}
	}
	
	
	function mergeParams( &$viewParams, $itemParams )
	{
		//print_r($viewParams);print_r($itemParams);
		foreach ($viewParams as $key=>&$value){
			if (array_key_exists ( $key , $itemParams )){
				$value = $itemParams[$key];
			}
		}
	}
	
	
	function isOuter( $url )
	{
		$is_outer = false;
		
		$www = JURI::base();
		if (strpos($www, '://www.') === false){
			$www2 = str_replace(array('http://', 'https://'), array('http://www.', 'https://www.'), JURI::base());
		}else{
			$www2 = str_replace(array('http://www.', 'https://www.'), array('http://', 'https://'), JURI::base());
		}
			
		if (strpos($url, 'http://') !== false){
			if ((strpos($url, $www) === false) && (strpos($url, $www2) === false)){
				$is_outer = true;
			}
		}
		
		return $is_outer;
	}
}
?>