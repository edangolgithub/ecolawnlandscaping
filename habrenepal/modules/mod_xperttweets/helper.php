<?php
/**
 * @package Xpert Tweets
 * @version 1.2
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2010 - 2012 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined('_JEXEC') or die;

// Includ the Twitter API wrapper class
require_once dirname(__FILE__) . '/vendor/twitter-api-php/TwitterAPIExchange.php';

// Load Joomla filesystem class
jimport('joomla.filesystem.file');

abstract class modXpertTweetsHelper
{
    public static $cache_path = '';

	public static function getTweets(&$params, $module_id)
	{

		$count 	= $params->get('count','5');

		//set max and min count
		if ($count > 200) 	$count = 200;
		if ($count < 1) 	$count = 1;

        /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
        $settings = array(
            'oauth_access_token'            => $params->get('access_token', '89146031-Jt6sMrcmEkgd9SgvpUNcIOIPRKOAhZfmQEKKoYBVI'),
            'oauth_access_token_secret'     => $params->get('access_token_secret', 'Xk983YpadIoRwQtnSc7fOmy8rWF78ju6r517ejrljg'),
            'consumer_key'                  => $params->get('consumer_key', 'RXoPcS0zjIZZmIuYVnRFg'),
            'consumer_secret'               => $params->get('consumer_secret', 'HZERCt5DvNkbgVkw6y2NbMzmbHk2OFhV2W93WHz0R0')
        );
		
        // Method
        $request_method = 'GET';

        // Final url
        if($params->get('show_tweet') == 'user')
        {
            $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
            $getfield = '?screen_name=' . $params->get('tweet_term','themexpert') . '&count=' . $count;;

        }elseif($params->get('show_tweet') == 'search')
        {
            $url = 'https://api.twitter.com/1.1/search/tweets.json';
            $getfield = '?q=' . urlencode($params->get('tweet_term','themexpert')) . '&count=' . $count;;
        }

        // Set the cache path
        self::setCachePath($module_id);

		$cache_time = $params->get('cache_time', 900);

		if( JFile::exists(self::$cache_path) )
		{
			$diff = ( time() - filectime(self::$cache_path) );
		}else{
			$diff = $cache_time + 1;
		}

        // If cache is expired we need to rebuild it
		if($diff > $cache_time)
		{
            try{
                $twitter = new TwitterAPIExchange($settings);
                $response = $twitter->setGetfield($getfield)
                         ->buildOauth($url, $request_method)
                         ->performRequest();    
            }catch( Exception $e)
            {
                echo $e->getMessage();
            }
			
            // Write the response buffer to cache file
            JFile::write( self::$cache_path, $response );
		}

        $data = json_decode( JFile::read(self::$cache_path) );
        $items = array();
        $i = 0;

        // var_dump($data);
        // If user reset the counter and it bigger then our cached tweet then we'll re-generate the cache again.
        // if( $params->get('show_tweet') == 'user' AND $count > count($data) )
        // {
        //     @JFile::delete( self::$cache_path );
        //     self::getTweets($params, $module_id);
        // }

        if($params->get('show_tweet') == 'user')
        {
            foreach($data as $tweet)
            {
                $obj = new stdClass;
                $obj->user = $tweet->user->screen_name;
                $obj->profile_image = $tweet->user->profile_image_url;
                $obj->source = $tweet->source;
                $obj->time = self::timeago($tweet->created_at);
                $obj->text = self::twittify($tweet->text);

                $items[$i] = $obj;
                $i++;
            }
        }

        elseif($params->get('show_tweet') == 'search')
        {
            foreach($data->statuses as $tweet)
            {
                $obj = new stdClass;
                $obj->user = $tweet->user->screen_name;
                $obj->profile_image = $tweet->user->profile_image_url;
                $obj->source = $tweet->source;
                $obj->time = self::timeago($tweet->created_at);
                $obj->text = self::twittify($tweet->text);

                $items[$i] = $obj;
                $i++;
            }
        }

        return $items;
	}

    public static function setCachePath( $module_id )
    {
        $cache_path = JPATH_ROOT. "/cache/mod_xperttweets$module_id/";
        $cache_file = md5($module_id) . '.cache';
        self::$cache_path = $cache_path . $cache_file; // Final cache path
    }

    public static function get_profile($params,$module_id)
    {
        if($params->get('show_tweet') == 'user')
        {
            if( JFile::exists(self::$cache_path) )
            {
                $data = json_decode( JFile::read(self::$cache_path) );
            }
        }

        $profile = array();
        $profile['name'] = $data[0]->user->name;
        $profile['description'] = $data[0]->user->description;
        $profile['url'] = $data[0]->user->url;
        $profile['followers'] = $data[0]->user->followers_count;
        $profile['following'] = $data[0]->user->friends_count;
        $profile['image_url'] = $data[0]->user->profile_image_url;

        return $profile;
    }

    // Add link to the url and user profiel, hashtag
	public static function twittify($tweet) 
    {
        require_once dirname(__FILE__) . '/vendor/Autolink.php';

		return Twitter_Autolink::create($tweet)
  				->setNoFollow(false)
  				->addLinks();
	}

    // Make time like twitter
	public static function timeago($time){
		//get current timestampt
	    $b = strtotime("now"); 
	    //get timestamp when tweet created
	    $c = strtotime($time);
	    //get difference
	    $d = $b - $c;
	    //calculate different time values
	    $minute = 60;
	    $hour = $minute * 60;
	    $day = $hour * 24;
	    $week = $day * 7;
        
    	if(is_numeric($d) && $d > 0) {
	        //if less then 3 seconds
	        if($d < 3) return "right now";
	        //if less then minute
	        if($d < $minute) return floor($d) . " seconds ago";
	        //if less then 2 minutes
	        if($d < $minute * 2) return "about 1 minute ago";
	        //if less then hour
	        if($d < $hour) return floor($d / $minute) . " minutes ago";
	        //if less then 2 hours
	        if($d < $hour * 2) return "about 1 hour ago";
	        //if less then day
	        if($d < $day) return floor($d / $hour) . " hours ago";
	        //if more then day, but less then 2 days
	        if($d > $day && $d < $day * 2) return "yesterday";
	        //if less then year
	        if($d < $day * 365) return floor($d / $day) . " days ago";
	        //else return more than a year
	        return "over a year ago";
    	}
	}

    /*
    * Load Stylesheet
    *
    */
    public static function load_stylesheet(&$params){
        $app        = JApplication::getInstance('site', array(), 'J');
        $template   = $app->getTemplate();
        $doc        = JFactory::getDocument();
        
        static $loadedBasicStyle;

        if ($loadedBasicStyle){
            return;
        }

        if (file_exists(JPATH_SITE.DS.'templates'.DS.$template.'/css/xperttweets.css')) {
           $doc->addStyleSheet(JURI::root(true).'/templates/'.$template.'/css/xperttweets.css');
        }
        else {
            $doc->addStyleSheet(JURI::root(true).'/modules/mod_xperttweets/tmpl/xperttweets.css');
        }

        $loadedBasicStyle = TRUE;

    }

}
