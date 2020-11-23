<?php
/**
 * @version		$Id: helper.php 5 2012-04-06 20:10:35Z chungtn2910 $
 * @copyright	JoomAvatar.com
 * @author		Tran Nam Chung
 * @mail		chungtn2910@gmail.com
 * @link		http://joomavatar.com
 * @license		License GNU General Public License version 2 or later
 */
defined( '_JEXEC' ) or die( 'Restricted access' );
class mod_avatar_twitter_widgetHelper
{
	public static function getdisplay($params){return $params->get('display');}
	public static function gettweetBtnTitle($params){return $params->get('tweetBtnTitle');}
	public static function gettweetBtnType($params){return $params->get('tweetBtnType');}
	public static function gettweetBtnSize($params){return $params->get('tweetBtnSize');}
	public static function gettweetCount($params){return $params->get('tweetCount');}
	public static function gettweetRelated($params){return $params->get('tweetRelated');}
	public static function gettweetUrl($params){return $params->get('tweetUrl');}
	public static function gettweetVia($params){return $params->get('tweetVia');}
	public static function gettweetHashtag($params){return $params->get('tweetHashtag');}
	public static function gettweetHashtagTxt($params){return $params->get('tweetHashtagTxt');}
	public static function gettweetMentionNamge($params){return $params->get('tweetMentionNamge');}
	public static function getfollowBtn($params){return $params->get('followBtn');}
	public static function getfollowBtnTitle($params){return $params->get('followBtnTitle');}
	public static function getfollowWidth($params){return $params->get('followWidth');}
	public static function getfollowCount($params){return $params->get('followCount');}
	public static function getfollowBtnSize($params){return $params->get('followBtnSize');}
	public static function getfollowScreenName($params){return $params->get('followScreenName');}
	public static function getfollowAlign($params){return $params->get('followAlign');}
	public static function getwidgetType($params){return $params->get('widgetType');}
	public static function getuserName($params){return $params->get('userName');}
	public static function getsearch($params){return $params->get('search');}
	public static function gettitle($params){return $params->get('title');}
	public static function getcaption($params){return $params->get('caption');}
	public static function getlist($params){return $params->get('list');}
	public static function getwidth($params){return $params->get('width');}
	public static function getheight($params){return $params->get('height');}
	public static function getautoWidth($params){return $params->get('autoWidth');}
	public static function getliveResult($params){return $params->get('liveResult');}
	public static function getscrollBar($params){return $params->get('scrollBar');}
	public static function gettweet($params){return $params->get('tweet');}
	public static function gethashTags($params){return $params->get('hashTags');}
	public static function gettimeStamp($params){return $params->get('timeStamp');}
	public static function getavatar($params){return $params->get('avatar');}
	public static function gettweetInterval($params){return $params->get('tweetInterval');}
	public static function getloop($params){return $params->get('loop');} 
	public static function getshellBg($params){return $params->get('shellBg');}
	public static function getshellText($params){return $params->get('shellText');}
	public static function gettweetBg($params){return $params->get('tweetBg');}
	public static function gettweetText($params){return $params->get('tweetText');}
	public static function getlinks($params){return $params->get('links');}
	public static function getcr($params){return $params->get('cr');}
	public static function getwidgetId($params){return $params->get('widgetId');}
	


    //public static function get($params){return $params->get('');}
}
?>