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
	// Do not compress css if debug ON
	ob_start();
}else{
	// initialize ob_gzhandler to send and compress data
	ob_start ("ob_gzhandler");
	// If $outputFile is already cached? Just load it
	$outputFile = getCacheFolder() . '/jtouch.css';
	if(file_exists($outputFile)){
		$outputContent =  file_get_contents($outputFile);
	}else {
		// If js is not cached? Initialize compress function for minify it and there we go
		ob_start("compress");
	}
}

//required header info and character set
header("Content-type:text/css; charset=UTF-8");
//cache control to process
header("Cache-Control:must-revalidate");
//duration of cached content (1 hour)
$offset = 60 * 60 ;
//expiration header format
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
//send cache expiration header to broswer
header($ExpStr);

//Begin 
function compress($buffer) {
	//remove comments
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
	//remove tabs, spaces, new lines, etc.
	$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);
	//remove unnecessary spaces
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(';}', '}', $buffer);
	
	$buffer = "/* Generate time: " .gmdate("D, d M Y H:i:s",time()) ." */ \n\r" . $buffer;
	// Write to cache
	$cacheFolder =	getCacheFolder();
	if( $cacheFolder != '' ){
		file_put_contents($cacheFolder.'/jtouch.css', $buffer);
	}
	return $buffer;
}

function getCacheFolder(){
	$cacheFolder =	dirname ( __FILE__ );
	$cacheFolder = str_replace('/templates/jtouch25/css', '', $cacheFolder);
	$cacheFolder = str_replace('\templates\jtouch25\css', '', $cacheFolder);
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
	/* All js load begin now */
	require_once 'config.css.php';
	foreach ($loadCssFiles as $file){
		loadFile($file);
	}
endif;
?>