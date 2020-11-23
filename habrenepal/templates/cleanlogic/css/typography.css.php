<?php

/**
* @version 2.2
* @package cleanlogic
* @copyright (C) 2012 by Robin Jungermann
* @license Released under the terms of the GNU General Public License
**/

header("content-type: text/css");

$main_font_size = $_GET['main_font_size'];

echo ('

/* BASIC FONT SETTINGS ------------------------------------*/

html, body {
	height: 100%;
	margin: 0;
	padding: 0;
	font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
	font-size: '.$main_font_size.'px;
	line-height: 1.2em;
}


ul.menu li a,
ul.menu li span,
h1, h1 a, h1 span, 
h2, h2 a, h2 span, 
h3, h3 a, h3 span,
h4, h4 a, h4 span,
h5, h5 a, h5 span {
	text-decoration: none;
	word-wrap: break-word;
}

label, legend {
	font-size: 14px;
}

ul.latestnews a {
	font-size: 14px;
	font-weight: bold;
	text-decoration: none;
}

/* CUSTOM FONTS ------------------------------------*/

@font-face {
    font-family: "MavenProRegular";
    src: url("../fonts/maven_pro_regular-webfont.eot");
    src: url("../fonts/maven_pro_regular-webfont.eot?#iefix") format("embedded-opentype"),
         url("../fonts/maven_pro_regular-webfont.woff") format("woff"),
         url("../fonts/maven_pro_regular-webfont.ttf") format("truetype"),
         url("../fonts/maven_pro_regular-webfont.svg#MavenProRegular") format("svg");
    font-weight: normal;
    font-style: normal;
}



h1, h1 a, h1 span, 
h2, h2 a, h2 span, 
h3, h3 a, h3 span,
h4, h4 a, h4 span,
h5, h5 a, h5 span,
#navigation,
ul.latestnews a,
.phrases-box label, 
.only-box label,
.autocompleter-choices,
a.readmore, 
p.readmore a, 
.ct_customLink,
button,
.button
 {
	font-family: "MavenProRegular", "Trebuchet MS", Arial, Helvetica, sans-serif !important;
	letter-spacing: 0;
}

.flex-caption-text {
	font-family: "MavenProRegular", "Trebuchet MS", Arial, Helvetica, sans-serif;
	letter-spacing: 0;
}


/* FONT SIZES ------------------------------------*/

h1, h1 a, h1 span, 
h2, h2 a, h2 span, 
h3, h3 a, h3 span,
h4, h4 a, h4 span,
h5, h5 a, h5 span,
blockquote {
	display: block;
	font-family: "MavenProRegular", "Trebuchet MS", Arial, Helvetica, sans-serif !important;
	font-weight: normal !important;
	margin: 0;
	padding: 0;
	text-decoration: none;
	width: auto;
}

h1, h2, h3, h4, h5 {
	margin: 0 0 0 0;
}

h1, h1 a {
	font-size: 30px;
	line-height: 30px;
	text-shadow: 0px 2px 2px rgba(0, 0, 0, 0.20);
	margin-bottom: 18px;
	padding-bottom: 7px;
}

h2, h2 a, h2 span {
	font-size: 25px !important;
	line-height: 28px;
	text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.20);
	margin-bottom: 15px;
}

h3 , h3 a, h3 span {
	font-size: 20px;
	line-height: 24px;
	text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.20);
	margin-bottom: 7px;
}

h4 , h4 a, h4 span {
	font-size: 16px;
	line-height: 20px;
	text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.20);
	margin-bottom: 5px;
}

h5 , h5 a, h5 span {
	font-size: 12px;
	line-height: 16px;
	text-shadow: 0px 1px 1px rgba(0, 0, 0, 0.20);
	margin-bottom: 5px;
}

h1 a, h2 a, h3 a, h4 a, h5 a {
	cursor: pointer;	
}

blockquote {
	font-size: 18px;
	font-style:italic;
	line-height: 19px;
}

ul.menu li a,
ul.menu li span {
	font-size: 16px;
}
ul.menu ul li,
ul.menu ul li a,
ul.menu ul li span {
	font-size: 12px;
}

span.autocompleter-queried {
	font-size: 16px;
	font-weight: bold
}

.autocompleter-choices {
	font-size: 14px;
}

'); ?>