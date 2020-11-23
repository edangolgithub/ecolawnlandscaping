(function($) {
	var AppRouter = Backbone.Router.extend({

	    routes:{
	        ""					: "pageMain",
	        "*actions"			: "defaultRoute"
	    },

	    initialize: function () {
	        // Handle back button throughout the application
	        this.firstPage = true;
	    },

	    pageMain: function () {
	        jtouchLog('Router: open main page ');
	        this.changePage('#jt-page-main');
	        
	        // Display msg dialog if there has a msg
	        var msgPanel = $('#system-message');
			if(msgPanel.length > 0){
				$('#system-message-popup').popup({overlayTheme: 'a', positionTo: 'window', transition: 'slideup', history: false});
				$('#system-message-popup').bind({
					popupafterclose: function(event, ui) {
						//jtouchLog('close dialog box');
						msgPanel.remove();
					}
				});
				$('#system-message-popup').popup('open');
			}
	    },
	    
	    defaultRoute: function (action) {
	    	jtouchLog('Router: to ' + action);
	        this.changePage('#'+ action);
	    },
	    
	    changePage: function (page) {
	    	var pageType = $(page).attr('data-role');
	    	// Is Popup
	    	if( pageType == 'popup'){
	    		$(page).popup('open', { positionTo: "window" });
	    		return;
	    	}
	    	
	    	// Is Page
	    	if (pageType == 'page') {
		    	var transition = $.mobile.defaultPageTransition;
		        // We don't want to slide the first page
		        if (this.firstPage) {
		            transition = 'none';
		            this.firstPage = false;
		        }
		        $.mobile.changePage(page, {reverse: false, changeHash:false, transition: transition});
		    	//$.mobile.changePage( page, { reverse: false, changeHash: false } );
		        return;
	    	}
	    	
	    	// Is an anchor
	    	var anchor = $(page);
			if(anchor.length > 0) {
				target = anchor.offset().top;
				setTimeout(function(){
					jtouchLog('Scrolling to target  ' + target + ' of ' + page);
					$.mobile.silentScroll(target);
				}, 500);
			}
	    }

	});
	
	$(document).ready(function () {
	    jtouchLog('Router: Init App router with Backbone.js..');
	    app = new AppRouter();
	    Backbone.history.start();
	});
	
	
})(jQuery);