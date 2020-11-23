<?php/** * @version		$Id: index.php $ * @package		Joomla.Site * @copyright	Copyright (C) 2009 - 2011 SiteGround.com - All Rights Reserved. * @license		GNU General Public License version 3 or later; see LICENSE.txt     *	This program is free software: you can redistribute it and/or modify *  it under the terms of the GNU General Public License as published by *  the Free Software Foundation, either version 3 of the License, or *  (at your option) any later version. *  This program is distributed in the hope that it will be useful, *  but WITHOUT ANY WARRANTY; without even the implied warranty of *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the *  GNU General Public License for more details. *  You should have received a copy of the GNU General Public License *  along with this program.  If not, see <http://www.gnu.org/licenses/>. */// No direct access.defined('_JEXEC') or die;JHTML::_('behavior.framework', true);/* The following line gets the application object for things like displaying the site name */$app = JFactory::getApplication();$tplparams	= $app->getTemplate(true)->params;
$number_of_slides = htmlspecialchars($tplparams->get('number_of_slides'));
$slider_enabled = htmlspecialchars($tplparams->get('slider_enabled'));
$indexonly = htmlspecialchars($tplparams->get('slider_frontonly'));
?><!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>"><head>	<jdoc:include type="head" />	<!-- The following line loads the template CSS file located in the template folder. -->	<link rel="stylesheet" href="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/css/template.css" type="text/css" />	<script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/CreateHTML5Elements.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<?php if ($slider_enabled == 1) { ?> <script type="text/javascript" src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/galleria.js"></script><?php } ?>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->   </head><body class="page_bg">
	<?php $menu = &JSite::getMenu();
	if ($menu->getActive() == $menu->getDefault() or ($indexonly == 0)) :?>
	<header>
	<?php else: ?>
	<header style="height: 200px; border-bottom:5px solid #404040">
	<?php endif ?>
		<div class="sitename">
			<h1><a href="<?php echo $this->baseurl ?>"><?php echo $app->getCfg('sitename'); ?></a></h1>
			<h2><?php echo $this->description; ?></h2>
		</div>
		<?php if ($menu->getActive() == $menu->getDefault() or ($indexonly == 0)) :?>
		<div id="slidewrap">
			<div id="slideshow">
				<div id="galleria">
				      <?php if ($slider_enabled == 1) {for ($i = 1; $i <= $number_of_slides; $i++) { ?>
				          <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/image<? echo $i; ?>.jpg" alt="Slideshow Image" />
				      <?php }}?>
				    </div>
				    <script>
					    Galleria.loadTheme('<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/js/galleria.dots.js'); 
					    $('#galleria').galleria();
				    </script>
			</div>
		</div>
		
		<?php endif ?>
		
		<?php if (  ($slider_enabled == 0) and ($menu->getActive() == $menu->getDefault() or ($indexonly == 0) )   ): ?>
			<div id="slidewrap">
				<div id="slideshow">
					<div id="galleria">
					          <img src="<?php echo $this->baseurl ?>/templates/<?php echo $this->template ?>/images/image1.jpg" alt="Slideshow Image" />
					    </div> 
				</div>
			</div>
		
		<?php endif ?>
		
		<div id="search">
			<jdoc:include type="modules" name="position-0" />
		</div>
		
		<div class="top-menu">
			<div id="sgmenu">
				<jdoc:include type="modules" name="menuload" />
			</div>
		</div>
					</header>
	<div class="wrapcont">		<section id="content">
			<?php if( ($this->countModules('position-7')) and ($this->countModules('position-4') ) ) : ?>			<div class="maincol">			 				<?php elseif( !$this->countModules('position-7') and ($this->countModules('position-4') ) ) : ?>			<div class="maincol_w_left">			<?php elseif( $this->countModules('position-7') and (!$this->countModules('position-4') ) ) : ?>			<div class="maincol_w_right">			<?php else: ?>			<div class="maincol_full">			<?php endif; ?>						<?php if( $this->countModules('position-7') ) : ?>				<div class="leftcol">					<jdoc:include type="modules" name="position-7" style="rounded"/>				</div>			<?php endif; ?>						<div class="cont">							<jdoc:include type="message" />							<jdoc:include type="component" />					</div>							<?php if( $this->countModules('position-4') ) : ?>				<div class="rightcol">										<jdoc:include type="modules" name="position-4" style="rounded"/>				</div>			<?php endif; ?>			<div class="clr"></div>			</div>		</div></div></div>
		</section>
		<footer>
			<div id="footerwrap">
			<p style="text-align:center;"><?php $sg = ''; include "templates.php"; ?></p>
			</div>
		</footer>
	</div></body></html>