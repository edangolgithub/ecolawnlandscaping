<?php
/**
 * @version		$Id: mod_.php 5 2012-04-06 20:10:35Z chungtn2910 $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @mail		chungtn2910@gmail.com
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
require_once( dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php' );

$display1 		= mod_avatar_twitter_widgetHelper::getdisplay($params);
$display		= array($display1);
$cr 			= mod_avatar_twitter_widgetHelper::getcr($params);
$tweetBtnType 	= mod_avatar_twitter_widgetHelper::gettweetBtnType($params);
$tweetBtnSize 	= mod_avatar_twitter_widgetHelper::gettweetBtnSize($params);
$tweetCount	 	= mod_avatar_twitter_widgetHelper::gettweetCount($params);
$tweetRelated 	= mod_avatar_twitter_widgetHelper::gettweetRelated($params);
$tweetUrl 		= mod_avatar_twitter_widgetHelper::gettweetUrl($params);
$tweetVia 		= mod_avatar_twitter_widgetHelper::gettweetVia($params);
$tweetHashtag 	= mod_avatar_twitter_widgetHelper::gettweetHashtag($params);
$tweetHashtagTxt = mod_avatar_twitter_widgetHelper::gettweetHashtagTxt($params);
$tweetMentionNamge = mod_avatar_twitter_widgetHelper::gettweetMentionNamge($params);
$followBtn 		= mod_avatar_twitter_widgetHelper::getfollowBtn($params);
$followWidth 	= mod_avatar_twitter_widgetHelper::getfollowWidth($params);
$followCount 	= mod_avatar_twitter_widgetHelper::getfollowCount($params);
$followBtnSize 	= mod_avatar_twitter_widgetHelper::getfollowBtnSize($params);
$followScreenName = mod_avatar_twitter_widgetHelper::getfollowScreenName($params);
$followAlign 	= mod_avatar_twitter_widgetHelper::getfollowAlign($params);
$widgetId 	= mod_avatar_twitter_widgetHelper::getwidgetId($params);
//$ = mod_avatar_twitter_widgetHelper::get($params);
// $widgetType 	= mod_avatar_twitter_widgetHelper::getwidgetType($params);
// $userName 	= mod_avatar_twitter_widgetHelper::getuserName($params);
// $search 	= mod_avatar_twitter_widgetHelper::getsearch($params);
// $title 		= mod_avatar_twitter_widgetHelper::gettitle($params);
// $caption 	= mod_avatar_twitter_widgetHelper::getcaption($params);
// $list 		= mod_avatar_twitter_widgetHelper::getlist($params);
// $width 		= mod_avatar_twitter_widgetHelper::getwidth($params);
// $height 	= mod_avatar_twitter_widgetHelper::getheight($params);
// $autoWidth 	= mod_avatar_twitter_widgetHelper::getautoWidth($params);
// $liveResult = mod_avatar_twitter_widgetHelper::getliveResult($params);
// $scrollBar 	= mod_avatar_twitter_widgetHelper::getscrollBar($params);
// $tweet 		= mod_avatar_twitter_widgetHelper::gettweet($params);
// $hashTags 	= mod_avatar_twitter_widgetHelper::gethashTags($params);
// $timeStamp 	= mod_avatar_twitter_widgetHelper::gettimeStamp($params);
// $avatar 	= mod_avatar_twitter_widgetHelper::getavatar($params);
// $tweetInterval = mod_avatar_twitter_widgetHelper::gettweetInterval($params);
// $loop 		= mod_avatar_twitter_widgetHelper::getloop($params);
// $shellBg 	= mod_avatar_twitter_widgetHelper::getshellBg($params);
// $shellText 	= mod_avatar_twitter_widgetHelper::getshellText($params);
// $tweetBg 	= mod_avatar_twitter_widgetHelper::gettweetBg($params);
// $tweetText 	= mod_avatar_twitter_widgetHelper::gettweetText($params);
// $links 		= mod_avatar_twitter_widgetHelper::getlinks($params);


require( JModuleHelper::getLayoutPath( 'mod_avatar_twitter_widget' ) );
?>