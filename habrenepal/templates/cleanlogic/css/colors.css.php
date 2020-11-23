<?php

/**
* @version 2.2
* @package cleanlogic
* @copyright (C) 2012 by Robin Jungermann
* @license Released under the terms of the GNU General Public License
**/

header("content-type: text/css");



include_once("hsv_color.php");
include_once("prepare_colors.php");


ereg('MSIE ([0-9].[0-9])',$_SERVER['HTTP_USER_AGENT'],$reg);

if(!isset($reg[1])) { $ieVersion = 'none'; } 
else {
	if(floatval($reg[1]) == '9'){ $ieVersion = '9'; }				
	if(floatval($reg[1]) == '8'){ $ieVersion = '8'; }
}


echo("
@charset 'utf-8';
/* CSS Document */


#ct_errorWrapper, #ct_errorWrapper a {
	color: ".$menu_text_color.";
}

body, 
a,
#errorboxheader,
#errorboxoutline,
ul.autocompleter-choice,
ul.autocompleter-choices li.autocompleter-selected span.autocompleter-queried {
	color: ".$textColor.";
}

/* BASIC ELEMENTS ------------------------------*/

a:hover,
h1 a:hover,
h2 a:hover,
h3 a:hover,
h4 a:hover,
h5 a:hover,
#ct_loginHelpers li:hover a,
ul.latestnews li:hover a,
.ct_breadcrumbs a:hover,
a.readmore:hover, 
p.readmore a:hover,
.categories-list span.item-title a:hover,
.category td a:hover,
.category th a:hover,
.registration legend,
.search-results .result-title:hover,
.search-results .result-title:hover a,
ul.circleList li, 
ul.circleList li ul li,
.errorNumber
{
	color: ".$accentColor.";
}



/* SITE AREAS ------------------------------*/

body{
	background-image: url(../images/bg_main_".$bg_style.".png);
	background-position: center;
}

footer {
	bottom: 0;
	border-top: 1px solid rgba(255,255,255,0.25);
	background: -moz-linear-gradient(top,  rgba(0,0,0,0.05) 0%, rgba(0,0,0,0) 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(0,0,0,0.05)), color-stop(100%,rgba(0,0,0,0)));
	background: -webkit-linear-gradient(top,  rgba(0,0,0,0.05) 0%,rgba(0,0,0,0) 100%);
	background: -o-linear-gradient(top,  rgba(0,0,0,0.05) 0%,rgba(0,0,0,0) 100%);
	background: -ms-linear-gradient(top,  rgba(0,0,0,0.05) 0%,rgba(0,0,0,0) 100%);
	background: linear-gradient(top,  rgba(0,0,0,0.05) 0%,rgba(0,0,0,0) 100%);
	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#0d000000', endColorstr='#00000000',GradientType=0 );
}


.tip {
	background: ".$darkboxGradientLight.";
	background: url(../images/bg_tooltip.png) no-repeat, -moz-linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/bg_tooltip.png) no-repeat, -webkit-gradient(linear, left top, left bottom, color-stop(0%,".$darkboxGradientLight."), color-stop(100%,".$darkboxGradientDark."));
	background: url(../images/bg_tooltip.png) no-repeat, -webkit-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: url(../images/bg_tooltip.png) no-repeat, -o-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: url(../images/bg_tooltip.png) no-repeat, -ms-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: url(../images/bg_tooltip.png) no-repeat, linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	
	-pie-background: url(".$templateUrl."/images/bg_tooltip.png) no-repeat, linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
}


/* NAVIGATION ------------------------------*/

/* NAVIGATION ------------------------------*/

");

if($ieVersion != "8") {
echo("
ul.menu,
ul.menu ul,
.dropdown-menu,
.nav-tabs > li a {
	background: ".$bodyGradientLight.";
	background: -moz-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$bodyGradientLight."), color-stop(100%, ".$bodyGradientDark."));
	background: -webkit-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -o-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -ms-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
}
");}	


if($ieVersion == "8") {
	echo("ul.menu, 
		.dropdown-menu,
		.nav-tabs > li a { 
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$bodyGradientLight."', endColorstr='".$bodyGradientDark."',GradientType=0 );
		}
	");

	echo("ul.menu ul { background: ".$bodyGradientDark.";}");
}

echo(" }



ul.menu li a,
ul.menu li span {
	color: ".$menuTextColor.";
	text-shadow: 0px -1px 0px  rgba(0,0,0,0.5);
}

ul.menu ul li a,
ul.menu ul li span {
	color: ".$menuTextColor." !important;
	text-shadow: none;
}

ul.menu li:hover > a,
ul.menu li:hover > span,
ul.menu li.current > a,
ul.menu li.current > span, 
ul.menu li.active > a,
ul.menu li.active > span,
ul.menu li ul li:hover > a,
ul.menu li ul li:hover > span,
ul.menu li ul li.current > a, 
ul.menu li ul li.current > span, 
ul.menu li ul li.active > a,
ul.menu li ul li.active > span,
ul.menu li ul li ul li:hover > a,
ul.menu li ul li ul li:hover > span,
ul.menu li ul li ul li.current > a, 
ul.menu li ul li ul li.current > span, 
ul.menu li ul li ul li.active > a,
ul.menu li ul li ul li.active > span,
ul.autocompleter-choices li.autocompleter-selected { 
	background: ".$accentGradientLight.";
	background: -moz-linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$accentGradientLight."), color-stop(100%, ".$accentGradientDark."));
	background: -webkit-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -o-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -ms-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);

");
	
	if($ieVersion == "8") {
		echo("	filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='".$accentGradientLight."', endColorstr='".$accentGradientDark."',GradientType=0 );");
	}
	if($ieVersion == "9") {
		echo("-pie-background: linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);");
	}
	
		
echo("
	color: ".$buttonTextColor." !important;
	text-shadow: 0px -1px 0px rgba(0,0,0,0.3) !important;
}

ul.menu li:hover > a,
ul.menu li:hover > span,
ul.menu li.current > a,
ul.menu li.current > span, 
ul.menu li.active > a,
ul.menu li.active > span { 
	text-shadow: 0px -1px 0px rgba(0,0,0,0.3);
}

ul.autocompleter-choices li.autocompleter-selected,
ul.menu ul li:hover > a,
ul.menu ul li:hover > span,
ul.menu ul li.current, 
ul.menu ul li.active > a,
ul.menu ul li.active > span { 
	text-shadow: 0px -1px 0px rgba(0,0,0,0.8) !important;	
	border-radius: 3px;
}

ul.menu ul li:hover,
ul.menu ul li.current, 
ul.menu ul li.active {
	border: none;
}



/* SLIDER ELEMENTS ---------------------------*/

.flex-direction-nav li .next {
	background: url(../images/slider_next.png);
	background: ".$darkboxGradientLight.";
	background: url(../images/slider_next.png), -moz-linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_next.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$darkboxGradientLight."), color-stop(100%, ".$darkboxGradientDark."));
	background: url(../images/slider_next.png), -webkit-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_next.png), -o-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_next.png), -ms-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_next.png), linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	
	-pie-background: url(".$templateUrl."/images/slider_next.png) no-repeat left, linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
}

.flex-direction-nav li .prev {
	background: url(../images/slider_prev.png);
	background: ".$darkboxGradientLight.";
	background: url(../images/slider_prev.png), -moz-linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_prev.png), -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$darkboxGradientLight."), color-stop(100%, ".$darkboxGradientDark."));
	background: url(../images/slider_prev.png), -webkit-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_prev.png), -o-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_prev.png), -ms-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: url(../images/slider_prev.png), linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	
	-pie-background: url(".$templateUrl."/images/slider_prev.png) no-repeat left, linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
}

.flex-direction-nav li a {
	-webkit-box-shadow: inset 0px 1px 2px 0px rgba(0, 0, 0, 0.5);
	box-shadow: inset 0px 1px 2px 0px rgba(0, 0, 0, 0.5); 
}


.flex-control-nav li a {
	background: ".$darkboxGradientLight.";
	background: -moz-linear-gradient(top,  ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,".$darkboxGradientLight."), color-stop(100%,".$darkboxGradientDark."));
	background: -webkit-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: -o-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: -ms-linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	background: linear-gradient(top,  ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
	
	-pie-background: linear-gradient(top, ".$darkboxGradientLight." 0%,".$darkboxGradientDark." 100%);
		
	-webkit-box-shadow: inset 0px 1px 2px 0px rgba(0, 0, 0, 0.5);
	box-shadow: inset 0px 1px 2px 0px rgba(0, 0, 0, 0.5); 
}

.flex-control-nav li a.active,
.flex-control-nav li a:hover {
	background: ".$accentGradientDark.";
	background: -moz-linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$accentGradientLight."), color-stop(100%, ".$accentGradientDark."));
	background: -webkit-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -o-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -ms-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	
	-pie-background: linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	
	-webkit-box-shadow: inset 0px 1px 1px 0px rgba(255, 255, 255, 0.7), 0px 1px 2px 0px rgba(0, 0, 0, 0.5);
	box-shadow: inset 0px 1px 1px 0px rgba(255, 255, 255, 0.7), 0px 1px 2px 0px rgba(0, 0, 0, 0.5); 
}


/*
.pane-sliders div.panel {
	-webkit-box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.5);
	box-shadow: 0px 1px 2px 0px rgba(0, 0, 0, 0.5); 
	
	border-radius: 3px;
	padding: 5px 10px;
	margin-bottom: 2px;
}
*/


/* TEXT ------------------------------*/
h1, h1 a, h1 span, 
h2, h2 a, h2 span, 
h3, h3 a, h3 span,
h4, h4 a, h4 span,
h5, h5 a, h5 span,
.tip-title {
	color: ".$accentColor." !important;
}


.contact-address,
.contact-emailto,
.contact-telephone,
.contact-fax,
.contact-mobile,
.contact-webpage,
.contact-vcard {
	background-image: url(../images/icons_contactdetails_".$themeColor.".png);
}


/* BUTTONS, LINKS & FORM ELEMENTS ------------------------------*/

input.button,
button, 
.ct_buttonYellow, 
.ct_buttonRed, 
.ct_buttonBlue,
.ct_buttonGreen,
.ct_buttonPink,
.ct_buttonBlack,
.ct_buttonWhite,
.ct_buttonAccent,
#errorboxoutline a,
ul.pagenav li a {
	color: ".$buttonTextColor.";
}

input.button, 
button,
#errorboxoutline a {
	background: url(../images/bg_btn.png) no-repeat right;
	background: ".$accentGradientDark.";
	background: url(../images/bg_btn.png) no-repeat right, -moz-linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn.png) no-repeat right, -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$accentGradientLight."), color-stop(100%, ".$accentGradientDark."));
	background: url(../images/bg_btn.png) no-repeat right, -webkit-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn.png) no-repeat right, -o-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn.png) no-repeat right, -ms-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn.png) no-repeat right, linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	
	-pie-background: url(".$templateUrl."/images/bg_btn.png) no-repeat right, linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
}

ul.pagenav li a,
.ct_PaginationStart,
.ct_PaginationPrevious,
.ct_PaginationNext,
.ct_PaginationEnd,
.ct_PaginationPageActive,

.content_vote input.button,
.ct_buttonAccent {
	background: ".$accentGradientDark.";
	background: -moz-linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$accentGradientLight."), color-stop(100%, ".$accentGradientDark."));
	background: -webkit-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -o-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: -ms-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	
	-pie-background: linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
}

.ct_buttonYellow 
{
	color: #777 !important;
	background-color: #ffe400;
	background: -moz-linear-gradient(top,  #ffe400 0%, #af9417 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ffe400), color-stop(100%,#af9417));
	background: -webkit-linear-gradient(top,  #ffe400 0%,#af9417 100%);
	background: -o-linear-gradient(top,  #ffe400 0%,#af9417 100%);
	background:  -ms-linear-gradient(top,  #ffe400 0%,#af9417 100%);
	background:  linear-gradient(top,  #ffe400 0%,#af9417 100%);
	
	-pie-background: linear-gradient(top, #ffe400 0%, #af9417 100%);
} 

.ct_buttonRed 
{
	background-color: #ed0000;
	background: -moz-linear-gradient(top,  #ed0000 0%, #9e1815 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ed0000), color-stop(100%,#9e1815));
	background:  -webkit-linear-gradient(top,  #ed0000 0%,#9e1815 100%);
	background:  -o-linear-gradient(top,  #ed0000 0%,#9e1815 100%);
	background:  -ms-linear-gradient(top,  #ed0000 0%,#9e1815 100%);
	background:  linear-gradient(top,  #ed0000 0%,#9e1815 100%);
	
	-pie-background: linear-gradient(top, #ed0000 0%, #9e1815 100%);
} 

.ct_buttonBlue 
{
	background-color: #0072ff;
	background: -moz-linear-gradient(top,  #0072ff 0%, #29487a 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#0072ff), color-stop(100%,#29487a));
	background:  -webkit-linear-gradient(top,  #0072ff 0%,#29487a 100%);
	background:  -o-linear-gradient(top,  #0072ff 0%,#29487a 100%);
	background:  -ms-linear-gradient(top,  #0072ff 0%,#29487a 100%);
	background:  linear-gradient(top,  #0072ff 0%,#29487a 100%);
	
	-pie-background: linear-gradient(top, #0072ff 0%, #29487a 100%);
} 

.ct_buttonGreen 
{
	background-color: #58d000;
	background: -moz-linear-gradient(top,  #58d000 0%, #477d1d 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#58d000), color-stop(100%,#477d1d));
	background:  -webkit-linear-gradient(top,  #58d000 0%,#477d1d 100%);
	background:  -o-linear-gradient(top,  #58d000 0%,#477d1d 100%);
	background:  -ms-linear-gradient(top,  #58d000 0%,#477d1d 100%);
	background:  linear-gradient(top,  #58d000 0%,#477d1d 100%);
	
	-pie-background: linear-gradient(top, #58d000 0%, #477d1d 100%);
} 

.ct_buttonPink 
{
	background-color: #ff00ea;
	background: -moz-linear-gradient(top,  #ff00ea 0%, #af0577 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#ff00ea), color-stop(100%,#af0577));
	background:  -webkit-linear-gradient(top,  #ff00ea 0%,#af0577 100%);
	background:  -o-linear-gradient(top,  #ff00ea 0%,#af0577 100%);
	background:  -ms-linear-gradient(top,  #ff00ea 0%,#af0577 100%);
	background:  linear-gradient(top,  #ff00ea 0%,#af0577 100%);
	
	-pie-background: linear-gradient(top, #ff00ea 0%, #af0577 100%);
} 

.ct_buttonBlack 
{
	background-color: #000;
	background: -moz-linear-gradient(top,  #474747 0%, #000 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#474747), color-stop(100%,#000));
	background:  -webkit-linear-gradient(top,  #474747 0%,#000 100%);
	background:  -o-linear-gradient(top,  #474747 0%,#000 100%);
	background:  -ms-linear-gradient(top,  #474747 0%,#000 100%);
	background:  linear-gradient(top,  #474747 0%,#000 100%);
	
	-pie-background: linear-gradient(top, #474747 0%, #000 100%);
} 

.ct_buttonWhite 
{
	color: #777 !important;
	background-color: #fff;
	background: -moz-linear-gradient(top,  #fff 0%, #bababa 100%);
	background:  -webkit-gradient(linear, left top, left bottom, color-stop(0%,#fff), color-stop(100%,#bababa));
	background:  -webkit-linear-gradient(top,  #fff 0%,#bababa 100%);
	background:  -o-linear-gradient(top,  #fff 0%,#bababa 100%);
	background:  -ms-linear-gradient(top,  #fff 0%,#bababa 100%);
	background:  linear-gradient(top,  #fff 0%,#bababa 100%);
	
	-pie-background: linear-gradient(top, #fff 0%, #bababa 100%);
} 

input[type='text'], 
input[type='password'], 
input[type='email'],
input[type='text'],
select,
textarea {
	background: ".$inputColorLight.";	
}

input[type='text']:hover, 
input[type='password']:hover, 
input[type='email']:hover, 
input[type='text']:focus, 
input[type='password']:focus, 
input[type='email']:focus,
select:focus, 
textarea:focus {
	-moz-box-shadow: 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.";
	-webkit-box-shadow: 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.";
	box-shadow: 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.", 0px 0px 3px 0px ".$accentColor.";
}

/* MODULE BOX STYLES -------------------------------------*/

	.moduletable_ct_darkBox {
		background: ".$darkboxGradientLight.";
		background: -moz-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$darkboxGradientLight."), color-stop(100%, ".$darkboxGradientDark."));
		background: -webkit-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
		background: -o-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
		background: -ms-linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
		background: linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
		
		-pie-background: linear-gradient(top, ".$darkboxGradientLight." 0%, ".$darkboxGradientDark." 100%);
	}
	
	.moduletable_ct_lightBox {	
		background: ".$lightboxGradientLight.";
		background: -moz-linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$lightboxGradientLight."), color-stop(100%, ".$lightboxGradientDark."));
		background: -webkit-linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);
		background: -o-linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);
		background: -ms-linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);
		background: linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);

		-pie-background: linear-gradient(top, ".$lightboxGradientLight." 0%, ".$lightboxGradientDark." 100%);
	}


/* SEARCH HEADER ------------------------------*/

#ct_headerSearch .search input, 
#ct_headerSearch .finder input {
	background: ".$inputColorLight.";
	background-image:url(../images/bg_inputfield_search_".$themeColor.".png);
	");
	
	if($ieVersion == "8") {
		echo("background-image:url(../images/bg_inputfield_search_".$themeColor."_ie.png);");
	}
	
	echo("
	background-repeat: no-repeat;
}


.autocompleter-choices {
	background: ".$bodyGradientLight.";
	background: -moz-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$bodyGradientLight."), color-stop(100%, ".$bodyGradientDark."));
	background: -webkit-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -o-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: -ms-linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	background: linear-gradient(top, ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	
	-pie-background: linear-gradient(top,  ".$bodyGradientLight." 0%, ".$bodyGradientDark." 100%);
	
	-webkit-box-shadow: #111 0 3px 4px;
	box-shadow: #111 0 3px 4px;
}

/* LOGIN HEADER ------------------------------*/

#login-form.compact .button, #ct_headerLogin input.button {
	background: url(../images/bg_btn.png) no-repeat right;
	background: ".$accentGradientDark.";
	background: url(../images/bg_btn_login.png) no-repeat right, -moz-linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn_login.png) no-repeat right, -webkit-gradient(linear, left top, left bottom, color-stop(0%, ".$accentGradientLight."), color-stop(100%, ".$accentGradientDark."));
	background: url(../images/bg_btn_login.png) no-repeat right, -webkit-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn_login.png) no-repeat right, -o-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn_login.png) no-repeat right, -ms-linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	background: url(../images/bg_btn_login.png) no-repeat right, linear-gradient(top, ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
	
	-pie-background: url(".$templateUrl."/images/bg_btn_login.png) no-repeat right, linear-gradient(top,  ".$accentGradientLight." 0%, ".$accentGradientDark." 100%);
}


/* TABLES ------------------------------*/

.cat-list-row0 {
	background: rgba(".$tableRow0RGB[0].",".$tableRow0RGB[1].",".$tableRow0RGB[2].",0.25);
}
		
table.category th {
	background-color: ".$tabelHeaderBG." 
}

table.category  tr.cat-list-row0 td {
	background-color: ".$tabelRowOddBG."
}

table.category  tr.cat-list-row1 td {
	background-color: ".$tabelRowEvenBG."
}

span.highlight {
	background-color: ".ct_hsvShade($base_color, 0.25, 0)." !important;
}

/* LINK LIST ------------------------------*/

ul.latestnews li, 
ul.latestnews li:first-child {
	border-bottom: 1px dotted ".$fontColorBright1.";
}


/* TEXT COLORS ------------------------------*/
	

body {
	color: ".$fontColorBase.";
}

.title a span {
	color: ".$fontColorBase." !important;
}

label, legend {
	color: ".$fontColorBase.";
}

.moduletable_ct_linkList a {
	color: ".$fontColorBright1.";
}

.ct_tip, 
.ct_alert, 
.ct_info, 
.ct_video,
.ct_contact,
.ct_checklist,
.ct_calendar,
.ct_settings,
.ct_cart,
.ct_delivery,
.ct_sound,
.ct_map {
	color: ".$fontColorBase.";
	border-top: 1px dotted ".$fontColorBright1.";
	border-bottom: 1px dotted ".$fontColorBright1.";
}

.ct_inlineLink {
	background-image: url(../images/icon_link_arrow_small_".$themeColor.".png);
}
.ct_inlineLink:hover {
	background-image: url(../images/icon_link_arrow_small_hover.png);
}


#ct_headerSearch .search input,
input[type='text'], 
input[type='password'],
input[type='email'], 
input[type='text'], 
input[type='password'], 
input[type='email'],
select,
textarea {
	color: ".$fontColorBase.";
}

#ct_headerSearch .search input:focus,
input[type='text']:hover, 
input[type='password']:hover,
input[type='email']:hover, 
input[type='text']:focus, 
input[type='password']:focus, 
input[type='email']:focus,
select:focus, textarea:focus {
	color: ".$fontColorBase.";
}

table.category th, 
table.category th a,
.categories-list span.item-title a,
.category .item-title a {
	color: ".$fontColorBase.";
}

#system-message dd.message ul,
#system-message dd.error ul,
#system-message dd.warning ul,
#system-message dd.notice ul,
.bfErrorMessage {
	background-color: #fff !important; 
}

.tip {
	-webkit-box-shadow: 2px 4px 5px 0px rgba(0, 0, 0, 0.5);
	-moz-box-shadow: 2px 4px 5px 0px rgba(0, 0, 0, 0.5);
	box-shadow: 2px 4px 5px 0px rgba(0, 0, 0, 0.5);
}

.tip-title {
	color: #fff;
}

.tip-text {
	color: #ddd;
}

ul.latestnews li, ul.latestnews li:first-child {
	border-bottom: 1px dotted ".$fontColorBright1.";
}

.panel {
	border-top: 1px dotted ".$fontColorBright1.";
}

h1, h1 a { 
	border-bottom: 1px solid ".$fontColorBright2.";
}

ul.latestnews a {
	color: ".$fontColorBase.";
}

.article-info dd, .article-info dd a {
	color: ".$fontColorBright1.";
}

.ct_breadcrumbs span, .ct_breadcrumbs a {
	color: ".$fontColorBright1.";
}

.showHere {
	color: ".$fontColorDark1." !important;
}

a.readmore, p.readmore a {
	color: ".$fontColorDark1.";
}

ul.pagenav {
	border-top: 1px dotted ".$fontColorBright1.";
}

.print-icon {
	background: url(../images/bg_icon_print_".$themeColor.".png);
}

.email-icon {
	background: url(../images/bg_icon_mail_".$themeColor.".png);
}

.edit-icon {
	background: url(../images/bg_icon_edit_".$themeColor.".png);
}

");?>