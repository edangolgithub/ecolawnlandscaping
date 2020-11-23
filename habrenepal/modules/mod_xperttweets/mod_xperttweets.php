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

// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';

$module_id = $module->id;
$list = modXpertTweetsHelper::getTweets($params,$module_id);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

if($params->get('profile',0) AND $params->get('show_tweet') == 'user')
{
    $profile = modXpertTweetsHelper::get_profile($params, $module_id);
}
modXpertTweetsHelper::load_stylesheet($params);

require JModuleHelper::getLayoutPath('mod_xperttweets', $params->get('layout', 'default'));
