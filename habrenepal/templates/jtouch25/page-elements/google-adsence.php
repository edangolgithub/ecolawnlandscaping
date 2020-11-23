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

defined('_JEXEC') or die('Restricted access');
$adType = $this->params->get('jtouch-google-adsence-type', 'NATIVE');

$gadW = $this->params->get('jtouch-google-adsence-width', 320);
$gadH = $this->params->get('jtouch-google-adsence-height', 50);
// Add some css to header
$gadCss = "
.googleadgoeshere{width: {$gadW}px;height:{$gadH}px;}
";
$document = JFactory::getDocument();
$document->addStyleDeclaration($gadCss, 'jtouch.csscode');


if($adType == 'NATIVE'): ?>

		<script type="text/javascript">
		<!--
			google_ad_client 	= "<?php echo $this->params->get('jtouch-google-adsence-client', '');?>";
			google_ad_slot 		= "<?php echo $this->params->get('jtouch-google-adsence-slot', '');?>";
			google_ad_width 	= <?php echo $gadW;?>;
			google_ad_height 	= <?php echo $this->params->get('jtouch-google-adsence-height', 50);?>;
		//-->
		</script>
		
		<script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>

<?php
else:

	$GLOBALS['google']['client'] = $this->params->get('jtouch-google-adsence-client', '');
	$GLOBALS['google']['slotname']= $this->params->get('jtouch-google-adsence-slot', '');
	// Do not need to change anything here
	$GLOBALS['google']['https']=read_global('HTTPS');
	$GLOBALS['google']['ip']=read_global('REMOTE_ADDR');
	$GLOBALS['google']['markup']='xhtml';
	$GLOBALS['google']['output']='xhtml';
	$GLOBALS['google']['ref']=read_global('HTTP_REFERER');
	$GLOBALS['google']['url']=read_global('HTTP_HOST') . read_global('REQUEST_URI');
	$GLOBALS['google']['useragent']=read_global('HTTP_USER_AGENT');
	$google_dt = time();
	google_set_screen_res();
	google_set_muid();
	google_set_via_and_accept();
endif;

/************************ 	GOOGLE ADSENCE PHP CODE ************************/
function read_global($var) {
	return isset($_SERVER[$var]) ? $_SERVER[$var]: '';
}

function google_append_url(&$url, $param, $value) {
	$url .= '&' . $param . '=' . urlencode($value);
}

function google_append_globals(&$url, $param) {
	google_append_url($url, $param, $GLOBALS['google'][$param]);
}

function google_append_color(&$url, $param) {
	global $google_dt;
	$color_array = explode(',', $GLOBALS['google'][$param]);
	google_append_url($url, $param,
	$color_array[$google_dt % count($color_array)]);
}

function google_set_screen_res() {
	$screen_res = read_global('HTTP_UA_PIXELS');
	if ($screen_res == '') {
	$screen_res = read_global('HTTP_X_UP_DEVCAP_SCREENPIXELS');
	}
	if ($screen_res == '') {
	$screen_res = read_global('HTTP_X_JPHONE_DISPLAY');
	}
	$res_array = preg_split('/[x,*]/', $screen_res);
	if (count($res_array) == 2) {
	$GLOBALS['google']['u_w']=$res_array[0];
	$GLOBALS['google']['u_h']=$res_array[1];
	}
}

function google_set_muid() {
	$muid = read_global('HTTP_X_DCMGUID');
	if ($muid != '') {
		$GLOBALS['google']['muid']=$muid;
		return;
	}
	$muid = read_global('HTTP_X_UP_SUBNO');
	if ($muid != '') {
		$GLOBALS['google']['muid']=$muid;
		return;
	}
	$muid = read_global('HTTP_X_JPHONE_UID');
	if ($muid != '') {
		$GLOBALS['google']['muid']=$muid;
		return;
	}
	$muid = read_global('HTTP_X_EM_UID');
	if ($muid != '') {
		$GLOBALS['google']['muid']=$muid;
		return;
	}
}

function google_set_via_and_accept() {
	$ua = read_global('HTTP_USER_AGENT');
	if ($ua == '') {
		$GLOBALS['google']['via']=read_global('HTTP_VIA');
		$GLOBALS['google']['accept']=read_global('HTTP_ACCEPT');
	}
}

function google_get_ad_url() {
	$google_ad_url = 'http://pagead2.googlesyndication.com/pagead/ads?';
	google_append_url($google_ad_url, 'dt',
	round(1000 * array_sum(explode(' ', microtime()))));
	foreach ($GLOBALS['google'] as $param => $value) {
		if (strpos($param, 'color_') === 0) {
			google_append_color($google_ad_url, $param);
		} else if (strpos($param, 'url') === 0) {
			$google_scheme = ($GLOBALS['google']['https'] == 'on')
			? 'https://' : 'http://';
			google_append_url($google_ad_url, $param,
			$google_scheme . $GLOBALS['google'][$param]);
		} else {
			google_append_globals($google_ad_url, $param);
		}
	}
	return $google_ad_url;
}

$google_ad_handle = @fopen(google_get_ad_url(), 'r');
if ($google_ad_handle) {
	while (!feof($google_ad_handle)) {
		echo fread($google_ad_handle, 8192);
	}
	fclose($google_ad_handle);
}
