// Global setting for Jtouch js
var jtouchSettings = {
	// Show loading box while clicking to a link
	showLoadingPage: true,
	localHash:	''
};

/* Write to Console */
function jtouchLog(msg){
	try{
		if(typeof(console) == 'object'){
			console.log('[JT25] ', msg);
		}
	}catch (ex){}
}

/* Add2Home script */
var addToHomeConfig = {
	animationIn: 'bubble',
	animationOut: 'drop',
	lifespan:10000,
	expire:2,
	touchIcon:true,
	returningVisitor: true,
	autostart: jtouchShowAppDialog,
	message: jtouchAdd2HomMessage
};

//jQuery.noConflict();
jtouchSettings.localHash = window.location.hash;

(function($) {
	// Init some setting for JQM
	$(document).bind("mobileinit", function() {
		jtouchLog('Mobileinit loading..');
	
		$.mobile.page.prototype.options.addBackBtn = true;
		//$.mobile.page.prototype.options.backBtnTheme    = "d";
		$.mobile.listview.prototype.options.headerTheme = jtouchHeaderTheme;
		//$.mobile.touchOverflowEnabled = true;
		$.mobile.defaultPageTransition = jtouchPageTransition;
		
		$.mobile.ajaxEnabled = false;
		$.mobile.allowCrossDomainPages = false;
		$.mobile.linkBindingEnabled = false;
		$.mobile.hashListeningEnabled = false;
		  
		// Note that we recommend disabling this feature if Ajax is disabled or if extensive use of external links are used.
		// http://jquerymobile.com/demos/1.1.0-rc.2/docs/api/globalconfig.html
		$.mobile.pushStateEnabled = false;
		
		// Remove page from DOM when it's being replaced
	   /*
		$('div[data-role="page"]').live('pagehide', function (event, ui) {
	        $(event.currentTarget).remove();
	    });
		*/
		
		jtouchLog('Is grade A browser? ' + $.mobile.gradeA());
	});    

})(jQuery);
