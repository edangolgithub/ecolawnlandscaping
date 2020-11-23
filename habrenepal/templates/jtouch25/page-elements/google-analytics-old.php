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
?>

<script type="text/javascript">
(function($){
	$('[data-role=page]').live('pageshow', function (event, ui) {
	    try {
		    jtouchLog('Loading Google Analytics script..');
	    	var _gaq = _gaq || [];
	        _gaq.push(['_setAccount', 		'<?php echo $this->params->get('jtouch-google-account');?>']);
	        _gaq.push(['_setDomainName', 	'<?php echo $this->params->get('jtouch-google-domain');?>']);
	        
	        hash = location.hash;
	
	        if (hash) {
	            _gaq.push(['_trackPageview', hash.substr(1)]);
	        } else {
	            _gaq.push(['_trackPageview']);
	        }
	    } catch(err) {
			jtouchLog('Found some ERRs while loading Google Analytics:');
			jtouchLog(err);
	    }
	
	});
})(jQuery);
</script>
