<?php 
/**
 * @package 	Jtouch25 Template
 * @copyright	Copyright (C) 2011 - 2012 MobileMeWs.com. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
define('_JEXEC', 1);

// parameter
$outputContent = '';
$debug = false;

if( isset($_REQUEST['debug']) && $_REQUEST['debug'] == 1) $debug = true;

if($debug){
	// Do not compress js if debug is ON
	ob_start();
}else{
	
	// initialize ob_gzhandler to send and compress data
	ob_start ("ob_gzhandler");
	
	// If js is already cached? Just load it
	$jsFile = getCacheFolder() . '/jtouch.js';
	if(file_exists($jsFile)){
		$outputContent =  file_get_contents($jsFile);
	}else {
		// If js is not cached? Initialize compress function for minify it and there we go
		ob_start("compress");
	}
}
// required header info and character set
header("Content-type: application/x-javascript");

if(!$debug):
	// cache control to process
	header("Cache-Control: must-revalidate");
	// duration of cached content (1 hour)
	$offset = 60 * 60 ;
	// expiration header format
	$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
	// send cache expiration header to broswer
	header($ExpStr);
endif;

function compress($buffer) {
	
	$script = "/* Built at: " .gmdate("D, d M Y H:i:s",time()) ." */ \n\r";
	try{
		require_once 'jsminplus.php';
		$script .=  JSMinPlus::minify($buffer);
		/*
		require 'jspacker/class.JavaScriptPacker.php';
		$packer = new JavaScriptPacker($buffer, 'None', true, true);
		$script .= $packer->pack();
		*/
		/*
		require_once 'jsmin.php';
		$script .= JSMin::minify($buffer);
		*/
	}catch (Exception $e){
		//JSMinException
		//JError::raiseWarning(101, $e->getMessage());
		// Something wrong with the compression? Pure output without minify!
		$script .= $buffer;
	}
	
	// Write to cache
	$cacheFolder =	getCacheFolder();
	if( $cacheFolder != '' ){
		file_put_contents($cacheFolder.'/jtouch.js', $script);
	}
	return $script;
}


function getCacheFolder(){
	$cacheFolder =	dirname ( __FILE__ );
	$cacheFolder = str_replace('/templates/jtouch25/js', '', $cacheFolder);
	$cacheFolder = str_replace('\templates\jtouch25\js', '', $cacheFolder);
	$cacheFolder .= '/cache/jtouch25';
	if( ! is_dir($cacheFolder) ){
		if( mkdir($cacheFolder, 0775) ){
			return $cacheFolder;
		}else {
			return '';
		}
	}
	return $cacheFolder;
}

function loadFile($file){
	echo "/* {$file} */\n\r";
	if( file_exists($file) ){
		require($file);
	}
}

 
if($outputContent != ''):
	echo $outputContent;
else:
	require 'config.js.php';
	
	foreach ($loadJsFiles as $file){
		loadFile($file);
	}
endif;

