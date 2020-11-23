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

$tplVer					= 'v2526';

$app                	= JFactory::getApplication('site');
$document 				= JFactory::getDocument();
$pageId 				= JRequest::getInt('Itemid', 0);

$thisTplUrl 			=  $this->baseurl. '/templates/' . $this->template;
$thisTplPath 			= JPATH_ROOT.DS.'templates'.DS.$this->template;

$debug					= (int)$this->params->get('jtouch-debug', 1);
$jStructure				= ( (int)$this->params->get('jtouch-jqm-css', 1) == 2 )? 1 : 0;
$jJqueryLoad			= (int)$this->params->get('jtouch-jquery-load', 1);
// Nguyen 13.02.01: jtpage -> let Jtouch open a screenpage after initialized
$jtPage					= JRequest::getVar('jtpage', '');

$googleAdsence			= (int)$this->params->get('jtouch-google-adsence', 0);

// @Since 2.5.10: module mapping
$mmjtouch_banner		= $this->params->get('jtouch-mm-jtouch-banner', 'jtouch-banner');
$mmjtouch_panel			= $this->params->get('jtouch-mm-jtouch-panel', 'jtouch-panel');
$mmjtouch_top 			= $this->params->get('jtouch-mm-jtouch-top', 'jtouch-top');
$mmjtouch_user1			= $this->params->get('jtouch-mm-jtouch-user1', 'jtouch-user1');
$mmjtouch_user2 		= $this->params->get('jtouch-mm-jtouch-user2', 'jtouch-user2');
$mmjtouch_bottom		= $this->params->get('jtouch-mm-jtouch-bottom', 'jtouch-bottom');
$mmjtouch_footer 		= $this->params->get('jtouch-mm-jtouch-footer', 'jtouch-footer');
$mmjtouch_breadcrumb	= $this->params->get('jtouch-mm-jtouch-breadcrumb', 'jtouch-breadcrumb');

// Load Jtouch libs
require_once ($thisTplPath .DS .'utils' .DS .'jtouch25.utils.php');
// Auto detect built in support extension and load extra stuffs
Jtouch25Utils::extraExtensionInit($this->params);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		
		<?php 
			$iOSIconPath = $this->params->get('jtouch-ios-icons', '') ;
			if($iOSIconPath!=''):
				$iOSIconPath = $thisTplUrl.'/'.$iOSIconPath;
		?>
		<!-- Icons -->
	    <link rel="shortcut icon" 									href="<?php echo $iOSIconPath;?>/favicon.ico?<?php echo $tplVer;?>" />
	    <link rel="apple-touch-icon-precomposed" sizes="144x144" 	href="<?php echo $iOSIconPath;?>/logo-144.png?<?php echo $tplVer;?>" />
	    <link rel="apple-touch-icon-precomposed" sizes="114x114" 	href="<?php echo $iOSIconPath;?>/logo-114.png?<?php echo $tplVer;?>" />
	    <link rel="apple-touch-icon-precomposed" sizes="72x72" 		href="<?php echo $iOSIconPath;?>/logo-72.png?<?php echo $tplVer;?>" />
	    <link rel="apple-touch-icon-precomposed" 					href="<?php echo $iOSIconPath;?>/logo-57.png?<?php echo $tplVer;?>" />
		<?php endif;?>
		
		<!-- Css -->
		<?php require_once $thisTplPath.DS.'css'.DS.'css.php';?>
		
		<?php 
			// Check if we have a folder named 'customize' within jtouch25 template
			// If yes, will load template-overwrite.css - it is useful for doing hack to Jtouch css without overwrite by next upgrade
			if( file_exists($thisTplPath.DS.'customize'.DS.'mytheme.css') ):
		?>
			<link rel="stylesheet" href="<?php echo $thisTplUrl;?>/customize/mytheme.css?<?php echo $tplVer;?>" type="text/css" />
		<?php 
			endif;
		?>
		
		<!--[if IEMobile]>
		<![endif]--> 

		<!-- Js -->
		<script type="text/javascript">
			var jtouchPageId 			= <?php echo $pageId;?>;
			var jtouchPageTransition 	= '<?php echo $this->params->get('jtouch-page-transition', 'pop');?>';
			var jtouchHeaderTheme 		= '<?php echo $this->params->get('jtouch-header-theme', 'b');?>';
			var jtouchAdd2HomMessage 	= '<?php echo JText::_("TPL_JTOUCH25_ADD_2_HOME_TEXT");?>';
			var jtouchShowAppDialog 	= <?php echo ((int)$this->params->get('jtouch-ios-add-app', 0) == 1)? 'true' : 'false'; ?>;
			var jtouchPage					= '<?php echo $jtPage;?>';
		</script>
		
		<?php  require_once $thisTplPath.DS.'js'.DS.'js.php';?>
		
		<?php if( (int)$this->params->get('jtouch-google-analytics', 0) == 1): ?>
		<script type="text/javascript">
			var _gaq = _gaq || [];
			(function() {
				var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			})();
		</script>
		<?php endif; ?>
		
		<jdoc:include type="head" />

		<?php if ($this->countModules('jtouch-code-top')): ?>
		<jdoc:include type="modules" name="jtouch-code-top" style="jqmNone" />
		<?php endif;?>
	</head>
	<?php
		$extraTopCls = '';
		$hasBanner = false; 
		if(strlen( $this->params->get('jtouch-banner', '') ) > 4 || $this->countModules($mmjtouch_banner)){
			$hasBanner = true;
			$extraTopCls = 'jtouch-extratop';
		}
		
		$pageTheme = $this->params->get('jtouch-theme', 'd');
		$headerTheme = $this->params->get('jtouch-header-theme', 'b');
		$footerTheme = $this->params->get('jtouch-footer-theme', 'd');
			
		$fixedHeader = '';
		if( (int)$this->params->get('jtouch-fixed-header', 0) == 1 ){
			$fixedHeader = ' data-position="fixed" ';
			$extraTopCls .= " jtouch-fixed-header";
		}
			
		$fixedFooter = '';
		if( (int)$this->params->get('jtouch-fixed-footer', 0) == 1 ){
			$fixedFooter = ' data-position="fixed" ';
		}
		
		$headerBtnView = (int)$this->params->get('jtouch-header-button-view', 1);
		$extraBtnCls = '';
		$extraBtnData = '';
		if($headerBtnView == 3){
			$extraBtnCls = 'button-no-text';
			$extraBtnData = ' data-iconpos="notext" ';
		}

	?>
	<body id="jt-body-root" class="<?php echo $extraTopCls;?>">
		<!-- MAIN PAGE -->
		<?php  if( $hasBanner) : ?>
		<div id="jtouch-logo">
			<?php if( strlen( $this->params->get('jtouch-banner', '') ) > 4 ): ?>
			<a href="index.php"><img src="<?php echo $this->params->get('jtouch-banner'); ?>"/></a>
			<?php endif; ?>
			
			<?php if ($this->countModules($mmjtouch_banner)): ?>
				<jdoc:include type="modules" name="<?php echo $mmjtouch_banner; ?>" />
			<?php endif; ?>	
			<div class="clr"></div>
		</div>
		<?php endif;?>
		
		 <a href="#"  id="hidden_link" style="display:none;"></a>
		 <a id="topofpage" style="display:none;"></a>
		
		<div data-role="page" id="jt-page-main" class="page-<?php echo $pageId;?>" data-add-back-btn="true" data-back-btn-text="<?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?>" data-theme="<?php echo $pageTheme;?>">
			<?php 
			$isShowPanel = 0;
			if($this->params->get('jtouch-show-panel', 'none') != 'none'):
				$isShowPanel = ($this->params->get('jtouch-show-panel', 'left') == 'left')? 1 : 2;
			?>
			<!-- Main Panel -->
			<div data-role="panel" id="jt-main-panel" data-theme="<?php echo $pageTheme;?>" data-position="<?php echo $this->params->get('jtouch-show-panel', 'left');?>" data-position-fixed="true" data-display="<?php echo $this->params->get('jtouch-panel-type', 'reveal')?>">
				<jdoc:include type="modules" name="<?php echo $mmjtouch_panel;?>" />
    		</div>
			<!-- / Main Panel -->
			<?php endif;?>
			
			<?php if ($this->countModules('jtouch-nav') ||  $this->params->get('jtouch-display-header', 1) == 1):?>
			<div data-role="header" <?php echo $fixedHeader;?> data-theme="<?php echo $headerTheme;?>" class="main-page-header">
				<?php 
				// Display header bar or not?
				if( $this->params->get('jtouch-display-header', 1) == 1):
					$backBtn = (int)$this->params->get('jtouch-always-show-back', 0);
					if( $backBtn > 0 || $isShowPanel == 1): ?>
					<div data-role="controlgroup" data-type="horizontal" class="header-tools-left">
						<?php if($backBtn > 0):?>
						<a href="index.php" data-direction-lock="reverse" class="jt-back-button" <?php if($backBtn == 2): ?> data-iconpos="notext" class="button-no-text" <?php endif;?>  data-icon="arrow-l" data-role="button" id="jtouch-back-btn"  data-mini="true"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
						<?php endif; ?>
						
						<?php if($isShowPanel == 1):?>
						<a href="#jt-main-panel" data-role="button" data-mini="true" <?php if($headerBtnView!=2): ?>data-icon="bars" <?php endif;?> <?php echo $extraBtnData; ?> class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_PANEL_BUTTON_TEXT');?></a>
						<?php endif;?>
					</div>
					<?php endif; ?>
					
					<?php if ($this->countModules('jtouch-menu or jtouch-search or jtouch-tools or jtouch-menu-custom') || $isShowPanel == 1): ?>
					<div data-role="controlgroup" data-type="horizontal" class="header-tools-center">
						<?php if ($this->countModules('jtouch-tools')): ?>
						<a href="#jt-page-tools" <?php if($headerBtnView!=2): ?>data-icon="star" <?php endif;?> <?php echo $extraBtnData; ?> data-role="button" id="jtouch-tools" class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_MENU_TOOL');?></a>
						<?php endif;?>
						
						<?php if ($this->countModules('jtouch-search')): ?>
						<a href="#jt-page-search" <?php if($headerBtnView!=2): ?> data-icon="search" <?php endif;?> <?php echo $extraBtnData; ?> data-role="button" id="jtouch-search" class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_MENU_SEARCH');?></a>
						<?php endif;?>
						
						<?php if ($this->countModules('jtouch-menu')): ?>
						<a href="#jt-page-menu" <?php if($headerBtnView!=2): ?> data-icon="grid" <?php endif;?> <?php echo $extraBtnData; ?> data-role="button" id="jtouch-menu" class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_MENU_MENU');?></a>
						<?php endif;?>
						
						<?php if ($this->countModules('jtouch-menu-custom')): ?>
						<jdoc:include type="modules" name="jtouch-menu-custom" />
						<?php endif; ?>
					</div>
					<?php endif;?>
					
					<!-- No title -->
					<h1><!-- <?php echo $document->getTitle();?> --></h1>
					
					<?php 
					if ($this->countModules('jtouch-rtools or jtouch-rtools-custom') || $isShowPanel == 2): ?>
					<div data-role="controlgroup" data-type="horizontal" class="header-tools-right">
						<?php if($this->countModules('jtouch-rtools')):?>
						<a href="#jt-page-rtool" <?php if($headerBtnView!=2): ?> data-icon="gear" <?php endif;?> <?php echo $extraBtnData; ?> data-role="button" id="jtouch-rtool-btn" class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_MENU_RH_TOOL');?></a>
						<?php endif; ?>
						
						<?php if ($this->countModules('jtouch-rtools-custom')): ?>
						<jdoc:include type="modules" name="jtouch-rtools-custom" />
						<?php endif; ?>
						
						<?php if($isShowPanel ==2):?>
						<a href="#jt-main-panel" data-role="button" data-mini="true" <?php if($headerBtnView!=2): ?>data-icon="bars" <?php endif;?> <?php echo $extraBtnData; ?> class="<?php echo $extraBtnCls;?>"><?php echo JText::_('TPL_JTOUCH25_PANEL_BUTTON_TEXT');?></a>
						<?php endif;?>
					</div>
					<?php endif;?>
				<?php endif; // end display header or not ?>
				
				<?php if ($this->countModules('jtouch-nav')): ?>
				<div id="jtouch-nav">
					<div class="inner-nav-<?php echo $this->params->get('jtouch-display-header', 1);?>" data-role="navbar" data-theme="b" data-iconpos="left"><jdoc:include type="modules" name="jtouch-nav" /></div>
					<div class="clr"></div>
				</div>
				<?php endif; ?>
			</div> <!-- end data-role="header" -->
			<?php endif; ?>
			
			<div data-role="content" id="jtouch-page-body">
				<?php if( $googleAdsence == 1 || $googleAdsence == 3): ?>
				<div id="googleadgoeshere1">
					<div class="googleadgoeshere"> </div>
					<div class="clr"></div>
				</div>
				<?php endif;?>
				
				<?php if ($this->countModules($mmjtouch_top)): ?>
				<div id="jtouch-top">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_top;?>"  style="xhtml" />
				</div>
				<?php endif; ?>
				
				<?php if ($this->countModules($mmjtouch_user1)): ?>
				<div id="jtouch-user1">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_user1;?>" style="xhtml" />
				</div>
				<?php endif; ?>
				<div data-role="popup" id="system-message-popup" class="ui-content">
					<a href="#" onclick="$('#system-message-popup').popup('close');" data-role="button" data-theme="c" data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
					<jdoc:include type="message" />
				</div>
				
				<?php 
					$turnoffIds = trim($this->params->get('jtouch-turnoff-ids', '-1'));
					$turnedOff = false;
					
					if($turnoffIds == '-1' || $turnoffIds == '0' || $turnoffIds == ''){
						$turnedOff = false;
					}else{
						$turnoffIds = '0,'. $turnoffIds;
						$turnoffIds = explode(',', $turnoffIds);
						$currentID 	= JRequest::getInt('Itemid', 0);						
						if($currentID > 0){
							if(in_array($currentID, $turnoffIds)){
								$turnedOff = true;
							}
						}
					}
					
					if(!$turnedOff) :
				?>
					<div id="jdoc-component">
						<jdoc:include type="component" />
					</div>
					
				<?php endif;?>
				
				<?php if ( $this->countModules($mmjtouch_user2) ): ?>
				<div class="clr"></div>
				<div id="jtouch-user2">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_user2;?>" style="xhtml" />
				</div>
				<?php endif; ?>				
				
				<?php if ($this->countModules($mmjtouch_breadcrumb)): ?>
				<div class="clr"></div>
				<div id="page-pathway">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_breadcrumb;?>"   />
				</div>
				<?php endif; ?>
				
				<?php if ($this->countModules($mmjtouch_bottom)): ?>
				<div class="clr"></div>
				<div id="jtouch-bottom">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_bottom;?>" style="xhtml" />
				</div>
				<?php endif; ?>
					
				<?php if( $googleAdsence == 2 || $googleAdsence == 3): ?>
				<div id="googleadgoeshere2">
					<div class="googleadgoeshere"> </div>
					<div class="clr"></div>
				</div>
				<?php endif;?>
			</div>
			
			<div data-role="footer" <?php echo $fixedFooter;?> data-theme="<?php echo $footerTheme;?>">
				<?php if ($this->countModules($mmjtouch_footer) || $this->params->get('jtouch-show-powerby', 1) == 1 ): ?>
				<div id="page-footer">
					<jdoc:include type="modules" name="<?php echo $mmjtouch_footer;?>" />
					
					<?php if($this->params->get('jtouch-show-powerby', 1) == 1): ?>
					<div class="jtouch-copyright"><a href="http://www.jtouchmobile.com" target="_blank" title="Jtouch - free and best mobile template for Joomla, VirtuMart and Kunena">Mobile template &copy; JtouchMobile.com</a></div>
					<?php endif;?>
				</div>
				<?php endif; ?> 
			</div>
		</div>

		<!-- MENU PAGE -->
		<div data-role="page" id="jt-page-menu" class="page-menu-<?php echo $pageId;?>" data-theme="<?php echo $pageTheme;?>">
			<div data-role="header" <?php echo $fixedHeader;?> data-theme="<?php echo $headerTheme;?>">
				<a href="#jt-page-main" data-direction-lock="reverse" data-icon="arrow-l" data-role="button" id="jtouch-back-btn"  data-mini="true"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
				<h1><?php echo JText::_('TPL_JTOUCH25_MENU_MENU');?></h1>
			</div>
			<div data-role="content">
				<?php 
					$jtouchDesktopTpl = (int)$this->params->get('jtouch-desktop-template', -1);
					$desktopUrl = $this->params->get('jtouch-desktop-homepage', '');
					$url = null;
					if(strlen($desktopUrl) > 1){
						// Humm, we want to use static desktop link for switcher
						$url = clone JFactory::getURI($desktopUrl);
					}else{
						$url = clone JFactory::getURI();
					}
					$params = array('jtpl' => 0, 'force' => 0);
					$params = array_merge( $url->getQuery( true ), $params );
					$query = $url->buildQuery( $params );
					$url->setQuery( $query );
					$desktopUrl = $url->toString();
					

				?>
				<?php if ($jtouchDesktopTpl == 1):?>
					<a class="switchDesktop" href="<?php echo $desktopUrl;?>" data-icon="gear" data-theme="<?php echo $pageTheme;?>" data-role="button" target="_self" data-mini="true"><?php echo JText::_('TPL_JTOUCH25_SWITCH_TO_DESKTOP');?></a>
				<?php endif;?>
				
				<div id="jtouch-mainmenu"><jdoc:include type="modules" name="jtouch-menu" style="xhtml" /></div>
				
				<?php if ($jtouchDesktopTpl == 2):?>
					<a class="switchDesktop" href="<?php echo $desktopUrl;?>" data-icon="gear" data-theme="<?php echo $pageTheme;?>" data-role="button" target="_self" data-mini="true"><?php echo JText::_('TPL_JTOUCH25_SWITCH_TO_DESKTOP');?></a>
				<?php endif;?>
			</div>
		</div>
		<!-- MENU PAGE:END -->
		
		<!-- HEADER RIGHT HAND TOOL PAGE -->
		<div data-role="page" id="jt-page-rtool" class="page-rtool-<?php echo $pageId;?>" data-theme="<?php echo $pageTheme;?>">
			<div data-role="header" <?php echo $fixedHeader;?> data-theme="<?php echo $headerTheme;?>">
				<a href="#jt-page-main" data-direction-lock="reverse" data-icon="arrow-l" data-role="button" id="jtouch-back-btn"  data-mini="true"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
				<h1><?php echo JText::_('TPL_JTOUCH25_MENU_RH_TOOL');?></h1>
			</div>
			<div data-role="content">
				<jdoc:include type="modules" name="jtouch-rtools" />
			</div>
		</div>
		<!-- HEADER RIGHT HAND TOOL PAGE:END -->
		
		<!-- SEARCH PAGE -->
		<div data-role="page" id="jt-page-search" class="page-search-<?php echo $pageId;?>" data-theme="<?php echo $pageTheme;?>">
			<div data-role="header" <?php echo $fixedHeader;?> data-theme="<?php echo $headerTheme;?>">
				<a href="#jt-page-main" data-direction-lock="reverse" data-icon="arrow-l" data-role="button" id="jtouch-back-btn"  data-mini="true"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
				<h1><?php echo JText::_('TPL_JTOUCH25_MENU_SEARCH');?></h1>
			</div>
			<div data-role="content">
				<jdoc:include type="modules" name="jtouch-search" />
			</div>
		</div>
		<!-- SEARCH PAGE:END -->
		
		<!-- TOOLS PAGE -->
		<!-- tools module output -->
		<div data-role="page" id="jt-page-tab-module" class="page-tab-modules" data-theme="<?php echo $pageTheme;?>">
			<div data-role="content">
				<jdoc:include type="modules" name="jtouch-tools" theme="<?php echo $pageTheme;?>" style="jqmTabs" />
			</div>
		</div>
		<!-- tools page wrapper -->
		<div data-role="page" id="jt-page-tools" class="page-tools-<?php echo $pageId;?>" data-theme="<?php echo $pageTheme;?>">
			<div data-role="header" <?php echo $fixedHeader;?> data-theme="<?php echo $headerTheme;?>">
				<a href="#jt-page-main" data-direction-lock="reverse" data-icon="arrow-l" data-role="button" id="jtouch-back-btn"  data-mini="true"> <?php echo JText::_('TPL_JTOUCH25_BACK_BUTTON_TEXT');?> </a>
				<?php if ($this->countModules('jtouch-menu')): ?>
				<a href="#jt-page-menu" data-icon="grid" class="ui-btn-right"><?php echo JText::_('TPL_JTOUCH25_MENU_MENU');?></a>
				<?php endif;?>
				<h1><?php echo JText::_('TPL_JTOUCH25_MENU_TOOL');?></h1>
				<div id="page-tools-navbar"></div>
			</div>
			<div data-role="content">
				<div id="page-tools-content"></div>
			</div>
		</div>
		<!-- TOOLS PAGE:END -->
			
		<!-- EX JS SCRIPTS FOR JTOUCH -->
		<?php Jtouch25Utils::writeJs($this->params);?>
		
		<?php if( (int)$this->params->get('jtouch-google-analytics', 0) == 1){
			require_once 'page-elements/google-analytics.php';
		} ?>
		
		<?php if( $googleAdsence != 0): ?>
		<!-- Google Adsence -->
		<div id="jtouchadsense" style="display:none;">
			<?php require_once 'page-elements/google-adsence.php';?>
		</div>
		
		<script type="text/javascript">
		(function($){
			$(document).ready(function () {
				try{
					var ads_top = $("#jtouchadsense").find("iframe");
					jtouchLog('Google Adsence: Loading ');
					
					//This is where the ads will show when the page is first loaded
					$(ads_top).appendTo(".googleadgoeshere");
					$("#jtouchadsense").remove();

					$('div').live('pagehide',function(event, ui){
						//This is where the ads will show when a page transition
						$(ads_top).appendTo(".googleadgoeshere");
					});
				} catch(err) {
					jtouchLog('Google Adsence: Error');
					jtouchLog(err);
			    }
			});
		})(jQuery);
		</script>
		<!-- / Google Adsence -->
		<?php endif; ?>
		
		<!-- EX JS SCRIPTS FOR JTOUCH: END -->
		
		<div style="display:none;"><a href="http://www.jtouchmobile.com">JTouch Mobile Template for Joomla</a> (c) 2011 - 2013 JtouchMobile.com</div>
		
		<?php if ($this->countModules('touch-code-bottom')): ?>
		<jdoc:include type="modules" name="jtouch-code-bottom" style="jqmNone" />
		<?php endif;?>
		
  	</body>
</html>