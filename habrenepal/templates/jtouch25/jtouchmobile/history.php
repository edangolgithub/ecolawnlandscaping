<?php defined('_JEXEC') or die('Restricted access'); ?>

[TODO]
[testing] hash issue on press hard back btn: Backbone + router
	ref:
		http://view.jquerymobile.com/1.3.0/docs/examples/backbone-require/index.php
		http://backbonetutorials.com/what-is-a-router/
		http://coenraets.org/backbone/jquerymobile

[] test on other devices: http://www.mobilephoneemulator.com/
[] # exclude menu item(s) mobilized
[] + improvement for iOS6: http://www.mobilexweb.com/blog/iphone-5-ios-6-html5-developers
[] + force mobilize a specific page

[done 2.5.25-b1] jComment ex
[done 2.5.25-a1] css of navigation/pagging
[2.5.23] clear caching when install/upgrade
[2.5.23] Version checking http://forum.joomla.org/viewtopic.php?f=682&t=694575
[2.5.23] # - anchor work? http://forum.jquery.com/topic/jquery-mobile-anchor-linking
[done, 2.5.21] Modules on header bar
[2.5.21.rc1] jtpl=1&force=2 to temporary mobilize the selected page
[2.5.21.rc1] onClick to clear caching file

[done 2520-b1] # BUG: multilingual site, default mobile home page does not work

[done 2520-stable] # Split VM 2 to another download package?
[done 2520-a2] modal box for mobile preview window ref: http://docs.joomla.org/Template_parameters
[done 2520-a1] Optimize resources. Cache result to file
[done 2520-a1] header theme for sub menu : http://stackoverflow.com/questions/4891906/jquery-mobile-default-data-theme/6906519#6906519
[done 2520-a1] new nav menu, small icon for main menu page
[done, 2511] turn off default jquery script
[done, 2511] theme for footer
[done, 2510] module mapping: http://docs.joomla.org/JDocumentHTML/countModules

=====================
- Slide, Swipe js
http://swipejs.com/
http://www.woothemes.com/flexslider/
http://www.pixedelic.com/plugins/camera/
JQM: http://stackoverflow.com/questions/7293220/adding-jquery-mobile-swipe-event
	and: http://jquerymobile.com/demos/1.1.0/docs/api/events.html

Metro UI / Title WP
http://www.drewgreenwell.com/projects/metrojs#whatsPlanned


[HISTORY]
2013.03.20: 2.5.26
! Bring split button back to the menu layout
! New layout for VM category menu module
# fix Cache: display notice message if turn on Joomla debug mode
# fix redirect to mobile homepage does not work
# fix panel button does not shown if back button is Off

2013.03.06: 2.5.25-stable
! Upgrade jQueryMobile from 1.2.0 to 1.3.0
! Upgrade jQuery from 1.8.2 to 1.9.1
+ New feature: Panel

2013.02.25: 2.5.24-stable
stable released

2013.02.22: 2.5.24-rc.1
# link to the plugin on installation final message page

2013.02.05: 2.5.24-beta.2
+ new language file
+ Not break the layout when working with jQueryUI

2013.01.31: 2.5.24-beta.1
+ New way to control caching. Now available in Jtouch plugin
+ Support for VM 2.0.18

2013.01.01: 2.5.23 - stable
# fix js compressor on Windows machine

2013.01.01: 2.5.22 - stable
# tab not show on jt-tools
# can not switch to desktop on some mobile browsers

2012.12.18: 2.5.21 - stable
+ Turn On/Off header bar
# Multilingual & default mobile page fixes
! Update document

2012.11.28: 2.5.21 - RC1
# slideshow special chars fixes
+ jtpl=1&force=2 to temporary mobilize the selected page
+ onClick to clear caching file

2012.11.03: 2.5.20 -stable
# slideshow js error fixed!

2012.09.17: 2.5.20 - rc1

2012.09.05: 2.5.20 - beta1
# default mobile page does not work
+ new way to select template name for the plugin
! VM 2.0.11-d supported
! upgrade to JQM 1.2.0 final


2012.09.25: 2.5.20 - apha2
+ JQM 1.2.0-rc1
- Remove VM2 from original package (separated download)
# Preview window issue with FF

2012.09.05: 2.5.20 - apha1
+ JQM 1.2.0-a1
+ Add caching system
+ Preview Window on Admin panel

2012.08.02: 2.5.12 stable
# fix: fixed header without banner

2012.07.18: 2.5.11 stable
! upgrade jQueryMobile from 1.1.0 to 1.1.1 final
+ new: more style for Back button and footer bar
! new: ability to turn off default jquery.js

2012.07.08: 2.5.10 stable
+ new: Google Adsence without PHP code
+ new: module mapping
+ new: using jQuery .noConflict()
! improve css
# fix: separator menu has sub items not display well
# fix: remove missing div in search form
# fix: fixed header with logo


2012.06.15: 2.5.9 stable
+ add support google analytics
+ add all customizable stuffs now will not be override by the upgrade
! fix some css updated
! upgrade mobile detect lib to latest version: April 23, 2012

2012.05.31: 2.5.8 stable
# fix slideshow now can feed image from Images and Links
# fix article now can display image from Images and Links


2012.05.22: 2.5.7 stable
+ new slide-show mode for mod_article_news module
# fix: Add as App on iOS - now only display for the first time
# fix: not remember template after logged in or out

2012.05.16: 2.5.6 stable
+ new position: jtouch-rtools
+ set default home page for mobile version (jtouch plugin)


2012.05.04: 2.5.6 beta 1
+ new: new way to load resources (js,css) files
! upgrade tpl to VM 2.0.6

2012.04.24: 2.5.5 stable
# fix: GA code
+ Powered by link


2012.04.18: 2.5.5 beta5
# fix: mess why loading unknow anchor (2)
# fix: GA has no tracking 

2012.04.16: 2.5.5 beta4
# fix: mess why loading unknow anchor
+ kunena supported!

2012.04.11: 2.5.5 beta3
# fix: mod_virtuemart_product <a> tag


2012.04.10: 2.5.5 beta2
! mod_virtuemart_search: new search box
! mod_virtuemart_product rewrite
# fix: upadate product qty in cart page
 
2012.04.06: 2.5.5 beta1
+ JQM 1.1.0RC2 (test)

2012.03.15: 2.5.5 alpha
+ JQueryMobile 1.1
- Remove Diapo slideshow
+ PhotoSwipe slideshow added to VM 
! Css
! Search tools

2012.03.01: 2.5.4
# Fix: iOS redirect

2012.02.12: 2.5.1
!Fix: Google analytics files

2012.02.12: 2.5.1
+ Add more functions to jtouchmobile - mobile detect plugin

2012.02.05: 2.5.0
+ Upgrade to 2.5
+ Finder com+mod support
+ New Joomla message dialog 
+ Captcha support
+ Better view for VM on <800px w?

2012.01.05: 1.7.5.rc1
+ VM 2 supported

2011.12.01: 1.7.1.stable
+ Turn on/off component for frontpage
+ Template switcher in jtouchplugin
+ Mobilize com_users + mod_login
! Fix template params issue

2011.11.25: 1.7.0.rc1
+ First public release