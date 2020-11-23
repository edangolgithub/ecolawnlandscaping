<?php
/**
 * @package     cleanlogic
 * @author      Robin Jungermann
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
*/

defined('_JEXEC') or die;
JHTML::_('behavior.modal');
JHTML::_('behavior.framework', true);
require_once(JPATH_SITE . DS . 'templates' . DS . $this->template . DS . 'system' . DS . 'recolor.php');
$app = JFactory::getApplication();

$highlights1ModuleCount = $this->countModules('highlights_1_1 + highlights_1_2 + highlights_1_3 + highlights_1_4 + highlights_1_5 + highlights_1_6');

$maincontent1ModuleCount = $this->countModules('maincontent_1_1 + maincontent_1_2 + maincontent_1_3 + maincontent_1_4 + maincontent_1_5 + maincontent_1_6');

$maincontent2ModuleCount = $this->countModules('maincontent_2_1 + maincontent_2_2 + maincontent_2_3 + maincontent_2_4 + maincontent_2_5 + maincontent_2_6');

$footerModuleCount = $this->countModules('footer_1_1 + footer_1_2 + footer_1_3 + footer_1_4 + footer_1_5 + footer_1_6');

$contentLeft = 0;
$contentRight = 0;

if($this->countModules('left') > 0) {
	$contentLeft =	1;
}

if($this->countModules('right') > 0) {
	$contentRight =	1;
}
 
$moduleWidthcomponentContent = "ct_componentWidth_".(4 - ($contentLeft + $contentRight));

$templateURL = str_replace('/','%',$this->baseurl."/templates/".$this->template);

?>

<!doctype html>

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  
  <jdoc:include type="head" />
  
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/system/css/system.css" type="text/css" />
  
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/basics.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/layout.css.php?max_sitewidth=<?php echo $this->params->get('max_sitewidth','960');?>&amp;responsive=<?php echo $this->params->get('responsive','1');?>" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/menu.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
  
      <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/colors.css.php?base_color=<?php echo $this->params->get('base_color','6b7e8f');?>
&amp;accent_color=<?php echo $this->params->get('accent_color','bbff00');?>&amp;text_color=<?php echo $this->params->get('text_color','ffffff');?>&amp;menu_text_color=<?php echo $this->params->get('menu_text_color','ffffff');?>&amp;button_text_color=<?php echo $this->params->get('button_text_color','ffffff');?>&amp;bg_style=<?php echo $this->params->get('bg_style','01_alphablending'); ?>&amp;templateurl=<?php echo $templateURL; ?>" type="text/css" />
      
      
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/content_types.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/formelements.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/typography.css.php?main_font_size=<?php echo $this->params->get('main_font_size','12');?>" type="text/css" />
 
     <?php

    if(strstr($_SERVER['HTTP_USER_AGENT'],'iPad')){
	echo('
	<style>
	
		ul.menu ul {	
			display: none;

			padding: 0;
			width: auto;
			white-space: nowrap;
			position: absolute;
		
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
		
			-webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
			-moz-box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
			box-shadow: 0 1px 3px rgba(0, 0, 0, .3);
			
			-pie-box-shadow: 0 2px 0px rgba(0, 0, 0, 0.15);
		}
		
		/* dropdown */
		.ct_menu_horizontal ul.menu li:hover > ul {
			display: block;			
		}
		
		.ct_menu_vertical ul.menu li:hover > ul {
			display: inline-block;
		}

	</style>
	');
    }?>
 
 <!--[if IE 9]>
    <style>
    
    	body, 
    	#siteWrapper,
        header,
        #main section,
        
        .moduletable_ct_lightBox,
        .moduletable_ct_darkBox,
         
        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,
        
        #main img,
           
        ul.menu,
        ul.menu ul,
        ul.menu ul ul,
        ul.menu li > a,
        ul.menu li > span,
        ul.menu li ul li > a,
        ul.menu li ul li > span,
        ul.menu li ul li ul li > a,
        ul.menu li ul li ul li > span,
        
        .ct_pagination div,

        .autocompleter-choices,
        ul.autocompleter-choices li.autocompleter-selected,
        
  		.flex-direction-nav li .next,
        .flex-direction-nav li .prev,
        .flex-control-nav li a,
        .flex-control-nav li a.active,
        .flex-control-nav li a:hover,
        
        ul.pagenav li a,
        
        .pane-sliders div.panel,
                    
        input.button, 
        button,
        #errorboxoutline a
        
        ul.pagenav li a,
        
        .ct_buttonAccent, 
        .ct_buttonYellow, 
        .ct_buttonRed, 
        .ct_buttonBlue,
        .ct_buttonGreen,
        .ct_buttonPink,
        .ct_buttonBlack,
        .ct_buttonWhite,

        #login-form.compact .button,
        #ct_headerLogin input.button,
        .tip  {
            behavior:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/pie/PIE.php);
        }
    
    </style>
<![endif]-->

 <!--[if lt IE 9]>
	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/ie_fixes.css.php" type="text/css" />
<![endif]-->

 <!--[if lt IE 9]>
    <style>
    
    	body, 
    	#siteWrapper,
        header,
        #main section,
        
        .moduletable_ct_lightBox,
        .moduletable_ct_darkBox,
         
        input, 
        input[type="text"],
        input[type="password"],
        input[type="email"],
        textarea,

        ul.menu,

        .ct_pagination div,

        .autocompleter-choices,
        ul.autocompleter-choices li.autocompleter-selected,
        
  		.flex-direction-nav li .next,
        .flex-direction-nav li .prev,
        .flex-control-nav li a,
        .flex-control-nav li a.active,
        .flex-control-nav li a:hover,
        
        ul.pagenav li a,
        
        .pane-sliders div.panel,
                    
        input.button, 
        button,
        #errorboxoutline a
        
        ul.pagenav li a,
        
        .ct_buttonAccent, 
        .ct_buttonYellow, 
        .ct_buttonRed, 
        .ct_buttonBlue,
        .ct_buttonGreen,
        .ct_buttonPink,
        .ct_buttonBlack,
        .ct_buttonWhite,
        
        #login-form.compact .button,
        #ct_headerLogin input.button,
        .tip  {
            behavior:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/pie/PIE.php);
        }
        
        ul.menu {
            -webkit-border-radius: 0px;
        	-moz-border-radius: 0px;
        	border-radius: 0px; 
       	}
    
    </style>
<![endif]-->


<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/libs/jquery-1.7.1.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.mobilemenu.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/jquery.ba-resize.min.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/touchmenu.js"></script>
<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/css3-mediaqueries.js"></script>


<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 9]>
	<script src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/html5.js"></script>
<![endif]-->


  
</head>

<body id="body">
<div id="siteWrapper">
    <header id="header">
      <div class="wrapper container">

        <div id="ct_headerTools">
            <div id="ct_headerSearch">
                <jdoc:include type="modules" name="searchHeader" style="xhtml" />
            </div>
            <div id="ct_headerLogin">
                <jdoc:include type="modules" name="loginHeader" style="xhtml" />
            </div>
        </div>
        

        <div class="siteLogo">
            <?php if ($this->params->get('logo')) : ?>
                <a href="<?php echo $this->baseurl ?>" id="logo">
                    <img src="<?php echo $this->baseurl.'/'.$this->params->get('logo'); ?>"/>
                </a> 
            <?php endif; ?>
        </div>

        <div class="ct_clearFloatLeft"></div>
        
        <nav id="navigation">
            <div id="mainMenu">
                <jdoc:include type="modules" name="mainNav" style="xhtml" />
            </div>
        </nav>
        
        <div class="ct_clearFloatBoth"></div>
        
       </div>



        <?php if ($this->countModules( 'breadcrumbs' )) : ?>
            <div class="ct_breadcrumbs"><jdoc:include type="modules" name="breadcrumbs" style="xhtml" /></div>
        <?php endif; ?>
        

    </header>
  



  
  	<jdoc:include type="message" />
  
	<?php if ($this->countModules( 'slider' )) : ?>
        <div id="ct_sliderWrapper">
            <div id="ct_sliderContent">
            	<jdoc:include type="modules" name="slider" style="xhtml" />
            </div>
        </div>
    <?php endif; ?>
  
    <div id="main">
      <div class="wrapper container">
        <?php if ($this->countModules( 'highlights_1_1 or highlights_1_2 or highlights_1_3 or highlights_1_4 or highlights_1_5 or highlights_1_6' )) : ?>
            <section>
                <div class="row columnWidth_<?php echo $highlights1ModuleCount ?>">
                    <?php if ($this->countModules( 'highlights_1_1' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_1" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'highlights_1_2' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_2" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'highlights_1_3' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_3" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'highlights_1_4' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_4" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'highlights_1_5' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_5" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'highlights_1_6' )) : ?>
                        <jdoc:include type="modules" name="highlights_1_6" style="xhtml" />
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
        
        <div class="ct_clearFloatLeft"></div>
        

        
     	<?php if ($this->countModules( 'maincontent_1_1 or maincontent_1_2 or maincontent_1_3 or maincontent_1_4 or maincontent_1_5 or maincontent_1_6' )) : ?>
                <section>
                <div class="row columnWidth_<?php echo $maincontent1ModuleCount ?>">
                    <?php if ($this->countModules( 'maincontent_1_1' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_1" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_1_2' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_2" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_1_3' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_3" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_1_4' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_4" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_1_5' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_5" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_1_6' )) : ?>
                        <jdoc:include type="modules" name="maincontent_1_6" style="xhtml" />
                    <?php endif; ?>
                 </div>
            </section>
   		<?php endif; ?>
   

    
    	<section>
        <div class="row">
			<?php if ($this->countModules( 'left' )) : ?>
                <div class="ct_left"><jdoc:include type="modules" name="left" style="xhtml" /></div>
            <?php endif; ?>
        
            <div class="ct_componentContent <?php echo $moduleWidthcomponentContent?>">
                <jdoc:include type="component" />
            </div>
            
            <?php if ($this->countModules( 'right' )) : ?>
                <div class="ct_right"><jdoc:include type="modules" name="right" style="xhtml" /></div>
            <?php endif; ?>
            
            <div class="ct_clearFloatBoth"></div>
            
        </div>
        </section>
          
        <?php if ($this->countModules( 'maincontent_2_1 or maincontent_2_2 or maincontent_2_3 or maincontent_2_4 or maincontent_2_5 or maincontent_2_6' )) : ?>
                <section>
                <div class="row columnWidth_<?php echo $maincontent2ModuleCount ?>">
                    <?php if ($this->countModules( 'maincontent_2_1' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_1" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_2_2' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_2" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_2_3' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_3" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_2_4' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_4" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_2_5' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_5" style="xhtml" />
                    <?php endif; ?>
                    
                    <?php if ($this->countModules( 'maincontent_2_6' )) : ?>
                        <jdoc:include type="modules" name="maincontent_2_6" style="xhtml" />
                    <?php endif; ?>
                </div>
            </section>
   		<?php endif; ?>
        
			<div class="ct_clearFloatLeft"></div>
			
   
        </div>
        
      
    </div>
               <footer>
                    <?php if ($this->countModules( 'footer_1_1 or footer_1_2 or footer_1_3 or footer_1_4 or footer_1_5 or footer_1_6' )) : ?>
                        <section>
                        <div class="row columnWidth_<?php echo $footerModuleCount ?>">
                            <?php if ($this->countModules( 'footer_1_1' )) : ?>
                                <jdoc:include type="modules" name="footer_1_1" style="xhtml" />
                            <?php endif; ?>
                            
                            <?php if ($this->countModules( 'footer_1_2' )) : ?>
                                <jdoc:include type="modules" name="footer_1_2" style="xhtml" />
                            <?php endif; ?>
                            
                            <?php if ($this->countModules( 'footer_1_3' )) : ?>
                                <jdoc:include type="modules" name="footer_1_3" style="xhtml" />
                            <?php endif; ?>
                            
                            <?php if ($this->countModules( 'footer_1_4' )) : ?>
                                <jdoc:include type="modules" name="footer_1_4" style="xhtml" />
                            <?php endif; ?>
                            
                            <?php if ($this->countModules( 'footer_1_5' )) : ?>
                                <jdoc:include type="modules" name="footer_1_5" style="xhtml" />
                            <?php endif; ?>
                            
                            <?php if ($this->countModules( 'footer_1_6' )) : ?>
                                <jdoc:include type="modules" name="footer_1_6" style="xhtml" />
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </footer>
            
            <div class="ct_clearFloatLeft"></div> 
</div>

</div>

<script>

    jQuery.noConflict();

    jQuery(document).ready(function() {
        
        jQuery(".row div:last-child").addClass("lastModule");

        var seen = {};
        jQuery('a').each(function() {
            var txt = jQuery(this).attr('href');
            if (seen[txt])
                jQuery(this).attr('href', txt + '#');
            else
                seen[txt] = true;
        });
        
        <?php if($this->params->get('responsive') == 1) echo ("jQuery('.ct_menu_horizontal > ul.menu').mobileMenu({switchWidth:769, prependTo: '#navigation', topOptionText: '".$this->params->get('show_menu_text', 'Select a Page')."'});"); ?>
    });
    

    function equalHeight(){
        
        var currentTallest = 0,
          currentRowStart = 0,
          rowDivs = new Array(),
          $el,
          $elementHeight,
          $totalHeight = 0,
          tallestContent = 0,
          topPosition = 0,
          lineNumber = 1;
                
        jQuery('.row > div').each( function() {
      
          $el = jQuery(this);
      
          topPostion = $el.position().top;
          
          jQuery(this).each(function(){
            jQuery(this).removeAttr("style")
          })
      
          // Get the total height of the module's content
          jQuery(this).children().each(function(){
            $totalHeight = $totalHeight + jQuery(this).outerHeight(true);
          })
          
          tallestContent =  (tallestContent < $totalHeight) ? ($totalHeight) : (tallestContent); 
          
          //console.log($totalHeight);
          //console.log("tallestContent: "+tallestContent);
          
          $totalHeight = 0;
          

          if (currentRowStart != topPostion) {
            
            lineNumber = lineNumber++;
            
            // we just came to a new row.  Set all the heights on the completed row
            for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
              if(currentDiv == 0) {rowDivs[currentDiv].css('margin-left', 0);};
              rowDivs[currentDiv].css('min-height', currentTallest+12);
            }
      
            // set the variables for the new row
            rowDivs.length = 0; // empty the array
            currentRowStart = topPostion;
            currentTallest = $el.height();
            rowDivs.push($el);

          } else {
      
             // another div on the current row.  Add it to the list and check if it's taller
             rowDivs.push($el);
             
             //currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
             currentTallest = tallestContent;
          }
         
           // do the last row
           for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
            if(currentDiv == 0) {rowDivs[currentDiv].css('margin-left', 0);};
            rowDivs[currentDiv].css('min-height', currentTallest+12);
          }
        });
      }

<?php if($this->params->get('equalmods') == 1) echo ("

  jQuery(window).resize(function() {
    setTimeout(equalHeight, 100);
  });
  
  jQuery(document).ready(function() {
    setTimeout(equalHeight, 100);
  });

");?>
</script>
<div style="display: block; text-align: center;">Get more <a href="http://crosstec.de/en/joomla-templates.html">Joomla!® Templates</a> and <a href="http://crosstec.de/en/extensions/joomla-forms-download.html">Joomla!® Forms</a> From <a href="http://crosstec.de/">Crosstec</a></div>
 
</body>
</html>