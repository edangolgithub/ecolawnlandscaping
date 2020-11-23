<?php
/**
 * @package     cleanlogic
 * @author      Robin Jungermann
 * @link        http://www.crosstec.de
 * @license     GNU/GPL
*/
defined('_JEXEC') or die;
JHTML::_('behavior.framework', true);
$app = JFactory::getApplication();

if (!isset($this->error)) {
	$this->error = JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
	$this->debug = false;
}
//get language and direction
$doc = JFactory::getDocument();
$this->language = $doc->language;
$this->direction = $doc->direction;
$this->params = JFactory::getApplication()->getTemplate(true)->params;
$templateURL = $this->baseurl."/templates/".$this->template;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
	<title><?php echo $this->error->getCode(); ?> - <?php echo $this->title; ?></title>
    
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/basics.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/layout.css.php?max_sitewidth=<?php echo $this->params->get('max_sitewidth','960');?>
  " type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />
  
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/colors.css.php?base_color=<?php echo $this->params->get('base_color','6b7e8f');?>
&amp;accent_color=<?php echo $this->params->get('accent_color','bbff00');?>&amp;text_color=<?php echo $this->params->get('text_color','ffffff');?>&amp;menu_text_color=<?php echo $this->params->get('menu_text_color','ffffff');?>&amp;button_text_color=<?php echo $this->params->get('button_text_color','ffffff');?>&amp;bg_style=<?php echo $this->params->get('bg_style','01_alphablending'); ?>&amp;templateurl=<?php echo $templateURL; ?>" type="text/css" />
      
      
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/content_types.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/typography.css" type="text/css" />

    
	<?php if ($this->direction == 'rtl') : ?>
	<link rel="stylesheet" href="<?php echo $this->baseurl; ?>/templates/system/css/error_rtl.css" type="text/css" />
	<?php endif; ?>
    
     <!--[if IE 9]>
    <style type="text/css">
    
    	body, 
    	#siteWrapper,
        #errorboxoutline a {
            behavior:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/pie/PIE.php);
        }
    </style>
<![endif]-->

<!--[if lte IE 8]>
    <style type="text/css">

    	body, 
    	#siteWrapper,
        #errorboxoutline a  {
            behavior:url(<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/pie/PIE.php);
        }
    </style>
<![endif]-->
    
<style>

body, html, #ct_errorWrapper  {
	height:100%;
	overflow: hidden;
}

</style>

    
</head>
<body id="siteWrapper">

<div id="ct_errorWrapper">


	<div class="error">
    <span class="errorNumber"><?php echo $this->error->getCode(); ?></span>
    <div id="errorboxheader"><?php echo $this->error->getMessage(); ?></div>
		
        <div id="outline">
		<div id="errorboxoutline">	
			<div id="errorboxbody">
			<p><strong><?php echo JText::_('JERROR_LAYOUT_NOT_ABLE_TO_VISIT'); ?></strong></p>
				<ol>
					<li><?php echo JText::_('JERROR_LAYOUT_AN_OUT_OF_DATE_BOOKMARK_FAVOURITE'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_SEARCH_ENGINE_OUT_OF_DATE_LISTING'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_MIS_TYPED_ADDRESS'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_YOU_HAVE_NO_ACCESS_TO_THIS_PAGE'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_REQUESTED_RESOURCE_WAS_NOT_FOUND'); ?></li>
					<li><?php echo JText::_('JERROR_LAYOUT_ERROR_HAS_OCCURRED_WHILE_PROCESSING_YOUR_REQUEST'); ?></li>
				</ol>
			<p><strong><?php echo JText::_('JERROR_LAYOUT_PLEASE_TRY_ONE_OF_THE_FOLLOWING_PAGES'); ?></strong></p>

				<ul>
					<li><a href="<?php echo $this->baseurl; ?>/index.php" title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>"><?php echo JText::_('JERROR_LAYOUT_HOME_PAGE'); ?></a></li>
				</ul>

			<p><?php echo JText::_('JERROR_LAYOUT_PLEASE_CONTACT_THE_SYSTEM_ADMINISTRATOR'); ?>.</p>
			<div id="techinfo">
			<p><?php echo $this->error->getMessage(); ?></p>
			<p>
				<?php if ($this->debug) :
					echo $this->renderBacktrace();
				endif; ?>
			</p>
			</div>
			</div>
		</div>
		</div>
	</div>

    
</div>


</body>
</html>
