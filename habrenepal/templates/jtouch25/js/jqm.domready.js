// Flag if the message box showed or not
var jtouchDialogShow = false;

// Flag if the tooks menu created of not
var jtouchToolsCreated = false;

// Flag if assign event to <a> tag
var jtouchATagEvent = false;

//Flag of open screen page
var jtPageDone			= false;

/**
 * Add a loading circle box when clicking to a link
 */
(function($){
	$(document).bind('pageinit', function(){
		if(jtouchATagEvent) return;
		if(jtouchSettings.showLoadingPage == false) return;
		
		jtouchATagEvent = true;
		
		$('a').each(function(i, el){
			$(el).click( function(){
				var href = $(this).attr('href');
				if(href == null) return;
				if(href[0] == '' || href[0] == '#') return;
				$.mobile.loading( "show" );
				
				setTimeout(function(){
					$.mobile.loading( "hide" );
				}, 3000);
			});
		});
	});
})(jQuery);


/**
 * Add event to Back button on Menu page
 */
(function($){
	$(document).bind('pageshow', function (){
		//Back button
		$('.jt-back-button').click( function(event) {
			jtouchLog('Back');
			event.preventDefault();
		    window.history.back();
		    return false;
		});
	});
})(jQuery);


/**
 * Force to open a page
 * Shoudl delay for 500ms - time for main screen page populate its content
 */
(function($){
	//$( '#jt-page-main' ).live( 'pageinit',function(event){
	$(document).bind('pageshow', function (){	
		//jtouchLog('Init page show..');
		if(!jtPageDone && jtouchPage!= ''){
			jtPageDone = true;
			setTimeout(function(){
				try{
					//jtouchLog('Open page #'+ jtouchPage);
					$.mobile.changePage('#' + jtouchPage);
				}catch (err){}
			}, 500);
		}	
	});
	
})(jQuery);


/**
 * Make tool tabs page (for cart page)
 * Waiting for official tab panel from JQM for a long long time - oops!
 */
(function($){
	var jtActiveTab = null;
	$(document).bind('pageshow', function (event, ui ){
		if($.mobile.activePage.attr('id') == 'jt-page-tools'){
			// Activate selected tab
			if(jtActiveTab != null) jtActiveTab.addClass('ui-btn-active');
		}
		
		if(jtouchToolsCreated) return;
		
		//jtouchLog('Creating system toolbar');
		$('#jt-page-tab-module').page(
			{
				  beforecreate: function( event, ui ) {
					  //jtouchLog('tools creating..');
				  }
			}
		);
		
		var ctlPage = $('#jt-page-tab-module').find('h1.tab-module-title');
		//jtouchLog('Number of tools = ' + ctlPage.length);
		if(ctlPage.length == 0) return;
		
		// Create navbar with content get from jtouch-tools position
		var ctlData = '';
		ctlPage.each(function(index){
			var ctlActiveClass = (index == 0)? ' class="ui-btn-active" ' : '';
			ctlData += '<li><a ' + ctlActiveClass +' title="#'+ $(this).attr('title') +'" href="#">' +  $(this).text() + '</a></li>';
		});
	
		var ctlElement = $('<div></div>', {
			'id':			'page-controll-navbar',
			'data-role':	'navbar',
			'html': 		'<ul>'+ ctlData +'</ul>'
		})
		.appendTo('#page-tools-navbar')
		.navbar();
		
		// Fade tab content on click
		var tabContent = null;
		$('#page-controll-navbar a').each(function(i){
			$(this).click(function(e){
				e.preventDefault();
				if(tabContent != null) tabContent.hide();
				
				tabContent = $($(this).attr('title'));
				$('#page-tools-content').append(tabContent);
				//tabContent.find( ":jqmData(role=listview)" ).listview();
	
				tabContent.fadeIn('slow');
				jtActiveTab = $(this);
			});
		});
		
		// Activate first tab
		$('#page-controll-navbar a:first').click();
		
		jtouchToolsCreated = true;
	});
})(jQuery);


/**
 * Switch to desktop button click event
 * Display confirm message and switching to desktop if should be
 */
var switchDesktop = false;
(function($){
	$(document).bind('pageshow', function (){
		if(switchDesktop) return;
		
		switchDesktop = true;
		$('.switchDesktop').click(function(){
			if(confirm("Switch to desktop version?") == true){
				 window.location.replace( $(this).attr('href') );
			}
			
			return false;
		});
	});
})(jQuery);