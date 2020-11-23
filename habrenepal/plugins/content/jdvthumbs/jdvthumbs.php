<?php
/**
* jdevelop.info
* @license              GNU General Public License
*/
 
// No direct access allowed to this file
defined( '_JEXEC' ) or die( 'Restricted access' );
 
// Import Joomla! Plugin library file
jimport('joomla.plugin.plugin');
require_once( dirname(__FILE__) . DS . 'helper.php' );
require_once( dirname(__FILE__) . DS . 'thumb2.class.php' );

//Import filesystem libraries. Perhaps not necessary, but does not hurt
jimport('joomla.filesystem.file');
 
//The Content plugin Loadmodule
class plgContentJdvthumbs extends JPlugin
{
		public function isBlog()
		{
			return ((JRequest::getCmd('view') == 'featured') || (JRequest::getCmd('view') == 'category') || (JRequest::getCmd('layout') == 'blog'));
		}
		
		public function onContentBeforeDisplay($context, &$article, &$params, $limitstart=0)
		{
			
			$app = JFactory::getApplication();
			if ( $app->isAdmin() ){
				return;
			}
			
			if ( !$this->isBlog() ) {
				return;		
			}
			
			
			if ( isset( $article->text ) ) {
				$text_save = $article->text;
			}
		
			$article->text = $article->introtext;
			$this->onPrepareContent ( $context, $article, $params, $limitstart);
			$article->introtext = $article->text;
			
			if ( isset( $text_save ) ) {
				$article->text = $text_save;
			}
			

		}
		
		
		function onPrepareContent ( $context, &$article, &$params, $page=0 ) {
			
			$option = JRequest::getVar( 'option', '', 'GET', 'STRING' );
			
			$loadSlimbox = $this->params->get( 'loadSlimbox', 0);
			$loadcss = $this->params->get( 'loadcss', 0);
			
			$thumbIntroImage = $this->params->get( 'thumbIntroImage', 1);
			
			$conf = JFactory::getConfig();
			$caching = $conf->getValue('config.caching');
			if (is_object($params)){
				$noCache = !$params->get('cache') || !$caching;
			}else{
				$noCache = !$caching;
			}

			if ($loadcss){
				jdvThumbsHelper::addCSS( 'jdvthumbs.css', JURI::base() . 'media/plg_content_jdvthumbs/css/', $noCache );
			}

			if ($loadSlimbox){
				jdvThumbsHelper::addScript( 'slimbox.js', JURI::base() . 'media/plg_content_jdvthumbs/slimbox/', $noCache );
				jdvThumbsHelper::addCSS( 'slimbox'.(JFactory::getLanguage()->isRTL() ? '-rtl' : '').'.css', JURI::base() . 'media/plg_content_jdvthumbs/slimbox/css/', $noCache );

			}
			
			//пропустить изображения в ссылках
			$regex = "/<a.*?>(.*?)<\/a>/is";
			preg_match_all($regex, $article->text, $matches);
			$count = count( $matches[0] );
			
			for ($n=0; $n < $count; $n++){
				preg_match('#href="(.*?)"#s', $matches[0][$n], $matche);
				//$a_href  = $matche[1];
				
				if (isset($matche[1])){
					$a_href  = $matche[1];
				}else{
					$a_href  = ''; 
				}
				
				$isImageInside = strpos(strtolower($matches[1][$n]), '<img');

				if (jdvThumbsHelper::isOuter( $a_href ) && $isImageInside === false){
				
					$matche = array();
					preg_match('#class="(.*?)"#s', $matches[0][$n], $matche);
					
					if (isset($matche[1])){
						$class = $matche[1];
						$new_class = "$class outer";
						$tag = str_replace('class="' . $class . '"', 'class="' . $new_class . '"', $matches[0][$n]);
						
					}else{
						$tag_part1 = substr($matches[0][$n], 0, 2);
						$tag_part2 = substr($matches[0][$n], 2);
						$tag = $tag_part1 . ' class="outer"' . $tag_part2;
						
						//echo $tag_part1 . $tag_part2;
						
						//$tag = '';
						//echo $n;
						//echo $matches[0][$n];
						//print_r($matches);
						
						//exit;
						//echo $matches[0][$n];

					}
					
					//mb_internal_encoding('UTF-8');
					$article->text 	= str_replace( $matches[0][$n], $tag, $article->text );
					//$article->text 	= preg_replace( '{'. $matches[0][$n] .'}', $tag, $article->text );
					//$matches[0][$n] = $tag;
				
				}
			}
			
			reset($matches);
			
			if ( $count ) {
					$this->_preprocess( $article, $matches, $count, $params );
			}
			
			//$matches = array();
			
			//пропустить изображения в контейнере с классом nothumb
			$regex = "/<div .*?nothumb.*?>(.*?)<\/div>/is";
			preg_match_all($regex, $article->text, $matches);


			
			$count = count( $matches[0] );
			
			reset($matches);
			
			if ( $count ) {
					$this->_preprocess( $article, $matches, $count, $params );
			}
			

			// expression to search for
			$regex = "/<img(.*?)>\s*(<\/img>)?/ ";


			// find all instances of plugin and put in $matches
			preg_match_all( $regex, $article->text, $matches );

			// Number of images
			$count = count( $matches[0] );
			
			
			//exit;

			// plugin only processes if there are any instances of the plugin in the text
			if ( $context != 'mod_custom.content' ) {
				if ($thumbIntroImage){
					$this->prepareThumbArticleParams($article);
				}
				if ( $count ) {
					$this->_process( $article, $matches, $count, $params );
				}
			}else{
				if ( $count ) {
					$this->_processModcustom( $article, $matches, $count, $params );
				}
			}
			
			// No return value
        }
		
		//добавляет класс nothumb
		function _preprocess ( &$article, &$matches, $count, $params )
		{
			for ($i=0; $i < $count; $i++){
			
				$regex = "/<img(.*?)>\s*(<\/img>)?/ ";

				// find all instances of plugin and put in $matches
				preg_match_all( $regex, $matches[1][$i], $img_matches );
			
				$img_count = count( $img_matches[0] );
				
				for ($n=0; $n < $img_count; $n++){

					preg_match('#class="(.*?)"#s', $img_matches[1][$n], $matche);
					
					if (isset($matche[1])){
						$img_class = $matche[1];
						$img_new_class = "$img_class nothumb";
						$img_tag = str_replace('class="' . $img_class . '"', 'class="' . $img_new_class . '"', $img_matches[0][$n]);
						
					}else{
						$tag_part1 = substr($img_matches[0][$n], 0, 4);
						$tag_part2 = substr($img_matches[0][$n], 4);
						$img_tag = $tag_part1 . ' class="nothumb"' . $tag_part2;
					}

					//mb_internal_encoding('UTF-8');
					
					$new_link 	= str_replace( $img_matches[0][$n], $img_tag, $matches[1][$i] );
					//$new_link 	= preg_replace( '{'. $img_matches[0][$n] .'}', $img_tag, $matches[1][$i] );
					//if (!empty($new_link) && isset($new_link) && $new_link != '')
					//$article->text 	= preg_replace( '{'. $matches[1][$i] .'}', $new_link, $article->text );
					$article->text 	= str_replace( $matches[1][$i], $new_link, $article->text );
				
				}
				
			}
		}
		

		function _process ( &$article, &$matches, $count, $params )
		{
		
			$Itemid = JRequest::getVar( 'Itemid', 0, null, 'INT' );

			$option = JRequest::getVar( 'option', '', 'GET', 'STRING' );
			$view = JRequest::getVar( 'view', '', 'GET', 'STRING' );

			$prefix = 'thumb-comp';
			$optionsIndex = 'category';

			if ($view == 'article'){
				$optionsIndex = $this->params->get( 'articleSetsFrom', 'article');	
			}
			if ($view == 'category'){
				$optionsIndex = $this->params->get( 'defaultSetsFrom', 'category');
			}
			if ($view == 'featured'){
				$optionsIndex = $this->params->get( 'featuredSetsFrom', 'featured');
			}

			if ($optionsIndex == 'article'){
				$prefix = 'thumb';
			}
			if ($optionsIndex == 'category'){
				$prefix = 'thumb-cat';
			}
			if ($optionsIndex == 'featured'){
				$prefix = 'thumb-fp';
			}



			$layout = JRequest::getVar( 'layout', '', 'GET', 'STRING' );
			$id = JRequest::getVar( 'id', 0, 'GET', 'INT' );
			$Itemid = JRequest::getVar( 'Itemid', '', 'GET', 'INT' );



			/* общие */
			
			
			$lightboxHandler = $this->params->get( 'lightboxHandler', 'rel');
			$attribValue = $this->params->get( 'attribValue', 'lightbox');
			
			//$reloption = $this->params->get( 'reloption', 'lightbox');
			//$classoption = $this->params->get( 'classoption', 'lightbox');
			
			$addarticleoption = $this->params->get( 'addarticleoption', 'slimbox');
			
			$target = $this->params->get( 'target', 'all');
			$thumbsFolder = $this->params->get( 'thumbsFolder', 'images/plg_jdvthumbs');
			$quality = $this->params->get( 'quality', 90);
			$method = $this->params->get( 'method', 'resampled');
			/* $pngAlphaChannel = $this->params->get( 'pngAlphaChannel', 0); */
			$pngAlphaChannel = 0;
			/* $thumbType = $this->params->get( 'thumbType', 'jpg'); */
			$thumbType = 'jpg';
			
			$thumbArea = $this->params->get( 'thumbArea', 'top');
			$notumbSize = $this->params->get( 'notumbSize', 100);
			
			$notApplyto = $this->params->get( 'notApplyto', 'nothumb');
			$applyto = $this->params->get( 'applyto', 'thumb');
			$skipOuter = $this->params->get( 'skipOuter', 1);
			$skipGIF = $this->params->get( 'skipGIF', 1);
			
			/* Advanced parameters */
			$typeBigThumbs = $this->params->get( 'typeBigThumbs', 'originale');
			$qualityForBigThumb = $this->params->get( 'qualityForBigThumb', 75);
			$widthForBigThumb = $this->params->get( 'widthForBigThumb', 1000);
			$heightForBigThumb = $this->params->get( 'heightForBigThumb', 750);
			$addLogoImage = $this->params->get( 'addLogoImage', 0);
			$logoPosition = $this->params->get( 'logoPosition', 'lefttop');
			$logoImage = $this->params->get( 'logoImage', 'images/powered_by.png');
			
			
			/* articles */
			$width['article'] = $this->params->get( 'widthForArticles', 200 );
			$height['article'] = $this->params->get( 'heightForArticles', 200 );
			$sizeon['article'] = $this->params->get( 'sizeonForArticles', 'both' );
			$media['article'] = $this->params->get( 'mediaForArticles', 'slimbox' );
			
			/* categories */
			$width['category'] = $this->params->get( 'widthDefault', 200);
			$height['category'] = $this->params->get( 'heightDefault', 200);
			$sizeon['category'] = $this->params->get( 'sizeonDefault', 'both' );
			if (!is_object($params)){
				$media['category'] = 'slimbox';
			}else{
				$media['category'] = $this->params->get( 'mediaDefault', 'article');
			}
			
			
			/* featured */
			$width['featured'] = $this->params->get( 'widthForFeatured', 200);
			$height['featured'] = $this->params->get( 'heightForFeatured', 200);
			$sizeon['featured'] = $this->params->get( 'sizeonForFeatured', 'both' );
			$media['featured'] = $this->params->get( 'mediaForFeatured', 'article');
			
			/* merge */
			$itemParams = jdvThumbsHelper::getItemidParams( 'a'.$Itemid, $this->params );
			
				
			$article_merge_params = array(
				'width'=>$width[$optionsIndex], 
				'height'=>$height[$optionsIndex], 
				'sizeon'=>$sizeon[$optionsIndex], 
				'media'=>$media['article']
			);

			//print_r($article_merge_params);
			
			jdvThumbsHelper::mergeParams( $article_merge_params, $itemParams);
			
			
			$itemParams = jdvThumbsHelper::getItemidParams( $Itemid, $this->params );
			
			
			$category_merge_params = array(
				'width'=>$width[$optionsIndex], 
				'height'=>$height[$optionsIndex], 
				'sizeon'=>$sizeon[$optionsIndex], 
				'media'=>$media['category']
			);
			
			jdvThumbsHelper::mergeParams( $category_merge_params, $itemParams);
			
			
			$itemParams = jdvThumbsHelper::getItemidParams( $Itemid, $this->params );
			
			
			$featured_merge_params = array(
				'width'=>$width[$optionsIndex], 
				'height'=>$height[$optionsIndex], 
				'sizeon'=>$sizeon[$optionsIndex], 
				'media'=>$media['featured']
			);

			
			
			jdvThumbsHelper::mergeParams( $featured_merge_params, $itemParams);

			$thumb_obj = new JdvThumbs2;
			
			
					
			$thumb_a = '';
			/* цикл по тегам img в материале */
			for ( $i=0; $i < $count; $i++ )
			{			
				$img = array();
				$attribs = array();
				$article_merge_params = array(
					'width'=>$width[$optionsIndex], 
					'height'=>$height[$optionsIndex], 
					'sizeon'=>$sizeon[$optionsIndex], 
					'media'=>$media['article']
				);


				

				$itemParams = jdvThumbsHelper::getItemidParams( 'a'.$Itemid, $this->params );
				jdvThumbsHelper::mergeParams( $article_merge_params, $itemParams);

				$img_tag = $matches[0][$i];
				
				preg_match('#src="(.*?)"#s',$img_tag,$matche);
				$img_src  = $matche[1];
				$img_src  = str_replace(JURI::base(), '', $img_src);
				$file = $img_src;
				
				if ($thumb_obj->getFileExt( $file ) == 'gif' && $skipGIF) {
					continue;
				}
				
				//$customfile = array();
				$customfile = '';
				
				$slash_pos = strpos($img_src, '/');
				$img_src = ( $slash_pos !== false && $slash_pos == 0 ? substr($img_src, 1) : $file );
				
				if (JFile::exists(dirname($img_src) . DS . 'custom-' . basename($img_src))){
					$customfile = dirname($img_src) . DS . 'custom-' . basename($img_src);
				}else{
					$customfile = $img_src;
				}

				
		
				list($width_source, $height_source) = @getimagesize($img_src);
				if ($width_source < $notumbSize || $height_source < $notumbSize){
					continue;
				}
				

				if ($skipOuter)
				if (jdvThumbsHelper::isOuter( $img_src )){
					continue;
				}
				
				/* alt */
				preg_match('#alt="(.*?)"#s',$img_tag,$matche);
				$img_alt       = isset($matche[1]) ? $matche[1] : '';
				if ($img_alt == ''){		
					if (isset($article->title)){
						$img_alt = htmlspecialchars($article->title);
					}else{
						$img_alt = basename($img_src);
					}
				}/* else if ($img_alt == basename($img_src)){
					if (isset($article->title)){
						$img_alt = $article->title;
					}
				} */
				/* title */
				preg_match('#title="(.*?)"#s',$img_tag,$matche);
				if (isset($matche[1])){
					$img['title']  = $matche[1];
				}
				/* align */
				preg_match('#align="(.*?)"#s',$img_tag,$matche);
				if (isset($matche[1])){
					$img['align']  = $matche[1];
				}
				
				preg_match('#style="(.*?)"#s',$img_tag,$matche);
				
				if (empty($matche)){
					$array_style = array();
				}else{
					$array_style = explode(';' ,$matche[1]);
				}
				
				for($n=0; $n < count($array_style); $n++){
					$array_style[$n] = trim($array_style[$n]);
					if ((strpos($array_style[$n], 'width') !== false)){
						$style_width = $array_style[$n];
						//unset($array_style[$n]);
					}
					if ((strpos($array_style[$n], 'height') !== false)){
						$style_height = $array_style[$n];
					}
					if ((strpos($array_style[$n], 'width') !== false) || (strpos($array_style[$n], 'height') !== false)){
						unset($array_style[$n]);
					}
				}
				
				$img_style = implode(';', $array_style);
				
				if ($img_style != ''){
					$img['style'] = $img_style;
				}
				
				preg_match('#class="(.*?)"#s',$img_tag,$matche);
				$img['class']  = isset($matche[1]) ? $matche[1] : '';
				
				$array_class = explode(' ', $img['class']);
				$array_noapply = explode(',', $notApplyto);
				for ($n=0; $n < count($array_noapply); $n++){
					$array_noapply[$n] = trim($array_noapply[$n]);
				}


				
				foreach($array_class as $value){

					

					if ($article_merge_params['sizeon'] == 'stylesize'){
						if (strpos($value, 'ss') === false) $value .= 'ss';
					}
				
					if (in_array(trim($value), $array_noapply)){
						continue 2;
					}
					
					$attribs = array();

					
					if ($target == 'class' && (
						($value != $applyto) 
							&& ($value != 'stylesize')
							&& ($value != 'ss')
							&& ($value != 'tagsize')
							&& ($value != 'ts')
						)
						){
						
						continue 2;
					}
					
					//echo trim($value);
					if (trim($value) == 'stylesize' || trim($value) == 'ss'){
						if (empty($style_width)) continue 2;;
						/* articles */
						$style_width = str_replace( array('width:', ';', ' ', 'px'), '', $style_width );
						$style_height = str_replace( array('height:', ';', ' ', 'px'), '', $style_height );
						$article_merge_params['width'] = $style_width;
						$article_merge_params['height'] = $style_height;
						
						
					}
					if (trim($value) == 'tagsize' || trim($value) == 'ts'){
						
						preg_match('#width="(.*?)"#s',$img_tag,$matche);
						if (isset($matche[1])){
							//$article_merge_params['width'] = str_replace( array('width:', ';', ' ', 'px'), '', $matche[1] );
							$article_merge_params['width'] = $matche[1];
						}
						preg_match('#height="(.*?)"#s',$img_tag,$matche);
						if (isset($matche[1])){
							//$article_merge_params['height'] = str_replace( array('height:', ';', ' ', 'px'), '', $matche[1] );
							$article_merge_params['height'] = $matche[1];
						}
						
					}
					if (
							(trim($value) != 'stylesize') 
							&& (trim($value) != 'ss')
							&& (trim($value) != 'tagsize')
							&& (trim($value) != 'ts')
						){
						$width['article'] = $this->params->get( 'widthForArticles', 200 );
						$height['article'] = $this->params->get( 'heightForArticles', 200 );
					}
					
				}


				
				$img['class'] = implode(' ' ,$array_class);
				$img['class'] = trim(str_replace(array('stylesize', 'ss', 'tagsize', 'ts'), '', $img['class']));
				
				if ($img['class'] != '') $img['class'] .= ' ';
				$img['class']  .= 'thumb-plg';
				
				
				//$fileBasename = basename($img_src);
				$fileBasename = JFile::getName($img_src);
				$fileBasename = JFile::stripExt($fileBasename);
				
				/* общие */
				$thumb_obj->set( 'thumbsdir', $thumbsFolder );
				$thumb_obj->set( 'quality', $quality );
				$thumb_obj->set( 'method',  $method );
				
				$thumb_obj->set( 'alpha',  $pngAlphaChannel );
				$thumb_obj->set( 'thumbtype',  $thumbType );
				$thumb_obj->set( 'thumbarea',  $thumbArea );

				
				
				//for big thumbs
				if (($typeBigThumbs == 'thumb')){
					$thumb_obj->set( 'quality', $qualityForBigThumb );
					$thumb_obj->set( 'width', $widthForBigThumb );
					$thumb_obj->set( 'height', $heightForBigThumb );
					$thumb_obj->set( 'sizeon', 'both' );
					//$thumb_obj->set( 'prefix', 'big' );
					$thumb_obj->set( 'prefix', $fileBasename );
					
					if ($addLogoImage){

						$thumb_obj->set( 'addlogo', $addLogoImage );
						$thumb_obj->set( 'logosrc', $logoImage );
						$thumb_obj->set( 'logoposition', $logoPosition );
					}

					$bigthumbsfiles = $thumb_obj->doThumbnail( $file );
					//print_r($bigthumbsfiles);
					
					$thumb_obj->set( 'addlogo', 0 );
					
					$source_url = $bigthumbsfiles[0];
					
					
					unset($bigthumbsfiles);
				}else{

					//$source_url = $thumb_obj->getURL($bigthumbsfiles[1][0]);
				}
				
				

				
				/* делаем эскизы для articles */
				if ($view == 'article'){


					$thumb_obj->set( 'prefix', $prefix . ($optionsIndex == 'article' ? /*$Itemid*/ '' : '') . '-' . $fileBasename );
					
					$thumb_obj->set( 'width',  $article_merge_params['width'] );
					$thumb_obj->set( 'height', $article_merge_params['height'] );
					$thumb_obj->set( 'sizeon', $article_merge_params['sizeon'] );
					
					
					if ($thumbArea == 'middle' && $article_merge_params['sizeon'] == 'crop'){
						$thumb_obj->set( 'sizeon', 'custom' );
						
						$k_source = $width_source / $height_source;
						$k_thumb = $article_merge_params['width'] / $article_merge_params['height'];
						
						
						if($k_thumb > $k_source){
							$src_w = $width_source;
							$k_thumbarea = $width_source / $article_merge_params['width'];
							$src_h = $article_merge_params['height'] * $k_thumbarea;
							$src_y = ($height_source - $src_h) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_y', $src_y );

						}else{

							$src_h = $height_source;
							$k_thumbarea = $height_source / $article_merge_params['height'];
							$src_w = $article_merge_params['width'] * $k_thumbarea;
							$src_x = ($width_source - $src_w) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_x', $src_x );

						}
						
					}
					
					
					
					if ($article_merge_params['sizeon'] == 'none'){
						continue;
						$custom_thumb_url = $customfile;
					}else{
						$customthumbsfiles = $thumb_obj->doThumbnail( $customfile );
						$custom_thumb_url = $customthumbsfiles[0];
					}
					



					$thumbsfiles = $thumb_obj->doThumbnail( $file );
					
				
						
					
					switch ($article_merge_params['media']){
					case 'slimbox':
						if (isset($img['title'])){
							$attribs['title'] = $img['title'];
							unset($img['title']);
						} else if (isset($article->title)){
							$attribs['title'] = htmlspecialchars($article->title);
						}else{
							$attribs['title'] = $img_alt;
						}
						
						
						
						
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						
						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];

						}
						
						if (!empty($lightboxHandler)){
							$attribs[$lightboxHandler] = "$attribValue";
							if ($addarticleoption == 'slimbox'){
								$attribs[$lightboxHandler] .= '-article';
							}
							if ($addarticleoption == 'widgetkit'){
								$attribs[$lightboxHandler] .= ';group:article;';
							}
							if ($addarticleoption == 'fancybox'){
								$attribs['rel'] .= ' group';
							}
						}
						
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					case 'window':
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						$attribs['target'] = '_blank';
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					default:
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						$attribs = array();
						$thumb_a = $thumb_img;
						break;
					}


				}	
				
				

				/* делаем эскизы для category */
				if ($view == 'category'){
					//$itemParams = jdvThumbsHelper::getItemidParams( 'c'.$Itemid, $this->params );
					
					//$thumb_obj->set( 'prefix',  'thumb-cat' . $Itemid );
					$thumb_obj->set( 'prefix',  $prefix . ($optionsIndex == 'category' ? /*$Itemid*/ '' : '') . '-' . $fileBasename );
					
					$thumb_obj->set( 'quality', $quality );
					$thumb_obj->set( 'width',  $category_merge_params['width'] );
					$thumb_obj->set( 'height', $category_merge_params['height'] );
					$thumb_obj->set( 'sizeon', $category_merge_params['sizeon'] );
					
					if ($thumbArea == 'middle' && $category_merge_params['sizeon'] == 'crop'){
						$thumb_obj->set( 'sizeon', 'custom' );
						
						$k_source = $width_source / $height_source;
						$k_thumb = $category_merge_params['width'] / $category_merge_params['height'];
						
						
						if($k_thumb > $k_source){
							$src_w = $width_source;
							$k_thumbarea = $width_source / $category_merge_params['width'];
							$src_h = $category_merge_params['height'] * $k_thumbarea;
							$src_y = ($height_source - $src_h) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_y', $src_y );

						}else{

							$src_h = $height_source;
							$k_thumbarea = $height_source / $category_merge_params['height'];
							$src_w = $category_merge_params['width'] * $k_thumbarea;
							$src_x = ($width_source - $src_w) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_x', $src_x );

						}
						
					}
					
					if ($category_merge_params['sizeon'] == 'none'){
						continue;
						$custom_thumb_url = $customfile;
					}else{
						$customthumbsfiles = $thumb_obj->doThumbnail( $customfile );
						$custom_thumb_url = $customthumbsfiles[0];
					}
					$thumbsfiles = $thumb_obj->doThumbnail( $file );
					
					
					

					
					switch ($category_merge_params['media']){
					case 'slimbox':
						if (isset($img['title'])){
							$attribs['title'] = $img['title'];
							unset($img['title']);
						} else if (isset($article->title)){
							$attribs['title'] = $article->title;
						}else{
							$attribs['title'] = $img_alt;
						}
						
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						
						if (!empty($lightboxHandler)){
							$attribs[$lightboxHandler] = "$attribValue";
							if ($addarticleoption == 'slimbox'){
								$attribs[$lightboxHandler] .= '-category';
							}
							if ($addarticleoption == 'widgetkit'){
								$attribs[$lightboxHandler] .= ';group:category;';
							}
							if ($addarticleoption == 'fancybox'){
								$attribs['rel'] .= ' group';
							}
						}
						
						

						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					case 'article':
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						require_once JPATH_SITE.'/components/com_content/helpers/route.php';
						
						$source_url = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, (isset($article->catslug) ? $article->catslug : $article->catid)));
						//$this->botMtLinkOn = JRoute::_(ContentHelperRoute::getArticleRoute($row->slug, $row->catid ));
						$attribs = array();
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
					
					case 'window':
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						$attribs = array( 'target'=>'_blank' );
						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					default:
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						$attribs = array();
						$thumb_a = $thumb_img;
						break;
					}
					
					
					
				}
							
			
				/* делаем эскизы для featured */
				if ($view == 'featured'){
	
					
					//$thumb_obj->set( 'prefix',  'thumb-fp' );
					$thumb_obj->set( 'prefix',  $prefix . ($optionsIndex == 'featured' ? /*$Itemid*/ '' : '') . '-' . $fileBasename );
					
					$thumb_obj->set( 'quality', $quality );
					$thumb_obj->set( 'width',  $featured_merge_params['width'] );
					$thumb_obj->set( 'height', $featured_merge_params['height'] );
					$thumb_obj->set( 'sizeon', $featured_merge_params['sizeon'] );
					
					
					if ($thumbArea == 'middle' && $featured_merge_params['sizeon'] == 'crop'){
						$thumb_obj->set( 'sizeon', 'custom' );
						
						$k_source = $width_source / $height_source;
						$k_thumb = $featured_merge_params['width'] / $featured_merge_params['height'];
						
						
						if($k_thumb > $k_source){
							$src_w = $width_source;
							$k_thumbarea = $width_source / $featured_merge_params['width'];
							$src_h = $featured_merge_params['height'] * $k_thumbarea;
							$src_y = ($height_source - $src_h) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_y', $src_y );

						}else{

							$src_h = $height_source;
							$k_thumbarea = $height_source / $featured_merge_params['height'];
							$src_w = $featured_merge_params['width'] * $k_thumbarea;
							$src_x = ($width_source - $src_w) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_x', $src_x );

						}
						
					}
					
					if ($featured_merge_params['sizeon'] == 'none'){
						continue;
						$custom_thumb_url = $customfile;
					}else{
						$customthumbsfiles = $thumb_obj->doThumbnail( $customfile );
						
						//print_r($customfile);
						
						$custom_thumb_url = $customthumbsfiles[0];
					}
					$thumbsfiles = $thumb_obj->doThumbnail( $file );
					
					

				
					switch ($featured_merge_params['media']){
					case 'slimbox':
						if (isset($img['title'])){
							$attribs['title'] = $img['title'];
							unset($img['title']);
						} else if (isset($article->title)){
							$attribs['title'] = $article->title;
						}else{
							$attribs['title'] = $img_alt;
						}
						
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						
						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						
						if (!empty($lightboxHandler)){
							$attribs[$lightboxHandler] = "$attribValue";
							if ($addarticleoption == 'slimbox'){
								$attribs[$lightboxHandler] .= '-featured';
							}
							if ($addarticleoption == 'widgetkit'){
								$attribs[$lightboxHandler] .= ';group:featured;';
							}
							if ($addarticleoption == 'fancybox'){
								$attribs['rel'] .= ' group';
							}
						}
						
						
						//$attribs['title'] = $img['title'];
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					case 'article':
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						require_once JPATH_SITE.'/components/com_content/helpers/route.php';
						$source_url = JRoute::_(ContentHelperRoute::getArticleRoute($article->slug, $article->catslug));
						
						$attribs = array();
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					case 'window':
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						$attribs = array( 'target'=>'_blank' );
						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					default:
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						$attribs = array();
						$thumb_a = $thumb_img;
						break;

					}
					
					
				}
				
				
				/* делаем эскизы компонентов - слимбокс параметры от категории переписываются параметрами из поля для пунктов меню */
				if ($option != 'com_content'){
					//$itemParams = jdvThumbsHelper::getItemidParams( 'c'.$Itemid, $this->params );
					
					//$thumb_obj->set( 'prefix',  'thumb-comp' . $Itemid );
					$thumb_obj->set( 'prefix',  $prefix . $Itemid . '-' . $fileBasename );


					if ($option == 'com_k2' && $view == 'item'){
						$thumb_obj->set( 'width',  $article_merge_params['width'] );
						$thumb_obj->set( 'height', $article_merge_params['height'] );
					}else{
						$thumb_obj->set( 'width',  $category_merge_params['width'] );
						$thumb_obj->set( 'height', $category_merge_params['height'] );
					}
					
					$thumb_obj->set( 'quality', $quality );

					$thumb_obj->set( 'sizeon', $category_merge_params['sizeon'] );
					
					
					if ($thumbArea == 'middle' && $category_merge_params['sizeon'] == 'crop'){
						$thumb_obj->set( 'sizeon', 'custom' );
						
						$k_source = $width_source / $height_source;
						$k_thumb = $category_merge_params['width'] / $category_merge_params['height'];
						
						
						if($k_thumb > $k_source){
							$src_w = $width_source;
							$k_thumbarea = $width_source / $category_merge_params['width'];
							$src_h = $category_merge_params['height'] * $k_thumbarea;
							$src_y = ($height_source - $src_h) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_y', $src_y );

						}else{

							$src_h = $height_source;
							$k_thumbarea = $height_source / $category_merge_params['height'];
							$src_w = $category_merge_params['width'] * $k_thumbarea;
							$src_x = ($width_source - $src_w) / 2; 
							
							$thumb_obj->set( 'src_w', $src_w );
							$thumb_obj->set( 'src_h', $src_h );
							$thumb_obj->set( 'src_x', $src_x );

						}
						
					}
					
					
					
					
					$customthumbsfiles = $thumb_obj->doThumbnail( $customfile );
					$thumbsfiles = $thumb_obj->doThumbnail( $file );

					
					$custom_thumb_url = $customthumbsfiles[0];
					

					
					switch ($category_merge_params['media']){
					default:
						if (isset($img['title'])){
							$attribs['title'] = $img['title'];
							unset($img['title']);
						} else if (isset($article->title)){
							$attribs['title'] = $article->title;
						}else{
							$attribs['title'] = $img_alt;
						}
						
						$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
						
						/* if ($lightboxHandler == 'rel'){
							$attribs['rel'] = "$reloption";
						}else{
							$attribs['class'] = "$classoption-" . $view . '-' . $id;
						} */
						
						if (!empty($lightboxHandler)){
							$attribs[$lightboxHandler] = "$attribValue";
							if ($addarticleoption == 'slimbox'){
								$attribs[$lightboxHandler] .= '-other';
							}
							if ($addarticleoption == 'widgetkit'){
								$attribs[$lightboxHandler] .= ';group:other;';
							}
						}

						if ($typeBigThumbs != 'thumb'){
							$source_url = $thumbsfiles[1];
						}
						$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
						break;
						
					
					}
						

				}

				$article->text 	= str_replace( $matches[0][$i], $thumb_a, $article->text );
			}
		}
		
		

		
		
		function _processModcustom ( &$article, &$matches, $count, $params )
		{
		
			$Itemid = JRequest::getVar( 'Itemid', 0, null, 'INT' );

			$option = JRequest::getVar( 'option', '', 'GET', 'STRING' );
			$view = JRequest::getVar( 'view', '', 'GET', 'STRING' );
			$layout = JRequest::getVar( 'layout', '', 'GET', 'STRING' );
			$id = JRequest::getVar( 'id', 0, 'GET', 'INT' );
			$Itemid = JRequest::getVar( 'Itemid', '', 'GET', 'INT' );

			/* общие */
			
			
			$lightboxHandler = $this->params->get( 'lightboxHandler', 'rel');
			$attribValue = $this->params->get( 'attribValue', 'lightbox');
			
			$reloption = $this->params->get( 'reloption', 'lightbox');
			$classoption = $this->params->get( 'classoption', 'lightbox');
			$addarticleoption = $this->params->get( 'addarticleoption', 1);
			
			$target = $this->params->get( 'target', 'all');
			$quality = $this->params->get( 'quality', 75);
			$method = $this->params->get( 'method', 'resized');
			$pngAlphaChannel = $this->params->get( 'pngAlphaChannel', 0);
			$thumbType = $this->params->get( 'thumbType', 'jpg');
			$thumbArea = $this->params->get( 'thumbArea', 'top');
			$notumbSize = $this->params->get( 'notumbSize', 100);
			
			$notApplyto = $this->params->get( 'notApplyto', 'nothumb');
			$applyto = $this->params->get( 'applyto', 'thumb');
			$skipOuter = $this->params->get( 'skipOuter', 1);
			$skipGIF = $this->params->get( 'skipGIF', 1);
			
			/* Advanced parameters */
			$typeBigThumbs = $this->params->get( 'typeBigThumbs', 'originale');
			$qualityForBigThumb = $this->params->get( 'qualityForBigThumb', 75);
			$widthForBigThumb = $this->params->get( 'widthForBigThumb', 1000);
			$heightForBigThumb = $this->params->get( 'heightForBigThumb', 750);
			$addLogoImage = $this->params->get( 'addLogoImage', 0);
			$logoPosition = $this->params->get( 'logoPosition', 'lefttop');
			$logoImage = $this->params->get( 'logoImage', 'images/powered_by.png');
			
			
			/* articles */
			$width['modcustom'] = $this->params->get( 'widthForModCustom', 200 );
			$height['modcustom'] = $this->params->get( 'heightForModCustom', 200 );
			$sizeon['modcustom'] = $this->params->get( 'sizeonForModCustom', 'both' );
			$sizeon['modcustom'] = 'width';
			$media['modcustom'] = $this->params->get( 'mediaForModCustom', 'slimbox' );
			


			
			
			$itemParams = jdvThumbsHelper::getItemidParams( 'a'.$Itemid, $this->params );
					
			$modcustom_merge_params = array(
				'width'=>$width['modcustom'], 
				'height'=>$height['modcustom'], 
				'sizeon'=>$sizeon['modcustom'], 
				'media'=>$media['modcustom']
			);
			
			jdvThumbsHelper::mergeParams( $modcustom_merge_params, $itemParams);
			
			


			
			$thumb_obj = new JdvThumbs2;
					
			$thumb_a = '';
			/* цикл по тегам img в материале */
			for ( $i=0; $i < $count; $i++ )
			{			
				$img = array();
				$modcustom_merge_params = array(
					'width'=>$width['modcustom'], 
					'height'=>$height['modcustom'], 
					'sizeon'=>$sizeon['modcustom'], 
					'media'=>$media['modcustom']
				);
				$itemParams = jdvThumbsHelper::getItemidParams( 'a'.$Itemid, $this->params );
				jdvThumbsHelper::mergeParams( $modcustom_merge_params, $itemParams);

				$img_tag = $matches[0][$i];
				
				preg_match('#src="(.*?)"#s',$img_tag,$matche);
				$img_src  = $matche[1];
				$img_src  = str_replace(JURI::base(), '', $img_src);
				$file = $img_src;
				
				if ($thumb_obj->getFileExt( $file ) == 'gif' && $skipGIF) {
					continue;
				}
				
				//$customfile = array();
				$customfile = '';
				
				$slash_pos = strpos($img_src, '/');
				$img_src = ( $slash_pos !== false && $slash_pos == 0 ? substr($img_src, 1) : $file );
				
				if (JFile::exists(dirname($img_src) . DS . 'custom-' . basename($img_src))){
					$customfile = dirname($img_src) . DS . 'custom-' . basename($img_src);
				}else{
					$customfile = $img_src;
				}

				
		
				list($width_source, $height_source) = @getimagesize($img_src);
				if ($width_source < $notumbSize || $height_source < $notumbSize){
					continue;
				}
				

				if ($skipOuter)
				if (jdvThumbsHelper::isOuter( $img_src )){
					continue;
				}
				
				/* alt */
				preg_match('#alt="(.*?)"#s',$img_tag,$matche);
				$img_alt       = isset($matche[1]) ? $matche[1] : '';
				if ($img_alt == ''){		
					if (isset($article->title)){
						$img_alt = $article->title;
					}else{
						$img_alt = basename($img_src);
					}
				}
				/* title */
				preg_match('#title="(.*?)"#s',$img_tag,$matche);
				if (isset($matche[1])){
					$img['title']  = $matche[1];
				}
				/* align */
				preg_match('#align="(.*?)"#s',$img_tag,$matche);
				if (isset($matche[1])){
					$img['align']  = $matche[1];
				}
				
				preg_match('#style="(.*?)"#s',$img_tag,$matche);
				
				if (empty($matche)){
					$array_style = array();
				}else{
					$array_style = explode(';' ,$matche[1]);
				}
				
				for($n=0; $n < count($array_style); $n++){
					$array_style[$n] = trim($array_style[$n]);
					if ((strpos($array_style[$n], 'width') !== false)){
						$style_width = $array_style[$n];
						//unset($array_style[$n]);
					}
					if ((strpos($array_style[$n], 'height') !== false)){
						$style_height = $array_style[$n];
					}
					if ((strpos($array_style[$n], 'width') !== false) || (strpos($array_style[$n], 'height') !== false)){
						unset($array_style[$n]);
					}
				}
				
				$img_style = implode(';', $array_style);
				
				if ($img_style != ''){
					$img['style'] = $img_style;
				}
				
				preg_match('#class="(.*?)"#s',$img_tag,$matche);
				$img['class']  = isset($matche[1]) ? $matche[1] : '';
				
				$array_class = explode(' ', $img['class']);
				$array_noapply = explode(',', $notApplyto);
				for ($n=0; $n < count($array_noapply); $n++){
					$array_noapply[$n] = trim($array_noapply[$n]);
				}
				
				foreach($array_class as $value){
				
					if (in_array(trim($value), $array_noapply)){
						continue 2;
					}
					
					if ($target == 'class' && (
						($value != $applyto) 
							&& ($value != 'stylesize')
							&& ($value != 'ss')
							&& ($value != 'tagsize')
							&& ($value != 'ts')
						)
						){
						
						continue 2;
					}
					
					//echo trim($value);
					if (trim($value) == 'stylesize' || trim($value) == 'ss'){
						if (empty($style_width)) continue 2;
						/* articles */
						$style_width = str_replace( array('width:', ';', ' ', 'px'), '', $style_width );
						$style_height = str_replace( array('height:', ';', ' ', 'px'), '', $style_height );
						$modcustom_merge_params['width'] = $style_width;
						$modcustom_merge_params['height'] = $style_height;
						
						
					}
					if (trim($value) == 'tagsize' || trim($value) == 'ts'){
						
						preg_match('#width="(.*?)"#s',$img_tag,$matche);
						if (isset($matche[1])){
							//$modcustom_merge_params['width'] = str_replace( array('width:', ';', ' ', 'px'), '', $matche[1] );
							$modcustom_merge_params['width'] = $matche[1];
						}
						preg_match('#height="(.*?)"#s',$img_tag,$matche);
						if (isset($matche[1])){
							//$modcustom_merge_params['height'] = str_replace( array('height:', ';', ' ', 'px'), '', $matche[1] );
							$modcustom_merge_params['height'] = $matche[1];
						}
						
					}
					if (
							(trim($value) != 'stylesize') 
							&& (trim($value) != 'ss')
							&& (trim($value) != 'tagsize')
							&& (trim($value) != 'ts')
						){
						$width['article'] = $this->params->get( 'widthForArticles', 200 );
						$height['article'] = $this->params->get( 'heightForArticles', 200 );
					}
					
				}
				
				$img['class'] = implode(' ' ,$array_class);
				$img['class'] = trim(str_replace(array('stylesize', 'ss', 'tagsize', 'ts'), '', $img['class']));
				
				if ($img['class'] != '') $img['class'] .= ' ';
				$img['class']  .= 'thumb-plg';
				
				
				
				
				/* общие */
				$thumb_obj->set( 'quality', $quality );
				$thumb_obj->set( 'method',  $method );
				
				$thumb_obj->set( 'alpha',  $pngAlphaChannel );
				$thumb_obj->set( 'thumbtype',  $thumbType );
				$thumb_obj->set( 'thumbarea',  $thumbArea );

				
				
				//for big thumbs
				if (($typeBigThumbs == 'thumb')){
					$thumb_obj->set( 'quality', $qualityForBigThumb );
					$thumb_obj->set( 'width', $widthForBigThumb );
					$thumb_obj->set( 'height', $heightForBigThumb );
					$thumb_obj->set( 'sizeon', 'both' );
					//$thumb_obj->set( 'prefix', 'big' );
					$thumb_obj->set( 'prefix', $fileBasename );
					
					
					if ($addLogoImage){

						$thumb_obj->set( 'addlogo', $addLogoImage );
						$thumb_obj->set( 'logosrc', $logoImage );
						$thumb_obj->set( 'logoposition', $logoPosition );
					}

					$bigthumbsfiles = $thumb_obj->doThumbnail( $file );
					//print_r($bigthumbsfiles);
					
					$thumb_obj->set( 'addlogo', 0 );
					
					$source_url = $bigthumbsfiles[0];
					
					
					unset($bigthumbsfiles);
				}else{

					//$source_url = $thumb_obj->getURL($bigthumbsfiles[1][0]);
				}
				
				
				
				
				/* делаем эскизы для mod_custom */


				
				//$thumb_obj->set( 'prefix', 'mod' . $Itemid );
				$thumb_obj->set( 'prefix', 'mod' . $Itemid . '-' . $fileBasename );
				
				$thumb_obj->set( 'width',  $modcustom_merge_params['width'] );
				$thumb_obj->set( 'height', $modcustom_merge_params['height'] );
				$thumb_obj->set( 'sizeon', $modcustom_merge_params['sizeon'] );
				
				
				if ($thumbArea == 'middle' && $modcustom_merge_params['sizeon'] == 'crop'){
					$thumb_obj->set( 'sizeon', 'custom' );
					
					$k_source = $width_source / $height_source;
					$k_thumb = $modcustom_merge_params['width'] / $modcustom_merge_params['height'];
					
					
					if($k_thumb > $k_source){
						$src_w = $width_source;
						$k_thumbarea = $width_source / $modcustom_merge_params['width'];
						$src_h = $modcustom_merge_params['height'] * $k_thumbarea;
						$src_y = ($height_source - $src_h) / 2; 
						
						$thumb_obj->set( 'src_w', $src_w );
						$thumb_obj->set( 'src_h', $src_h );
						$thumb_obj->set( 'src_y', $src_y );

					}else{

						$src_h = $height_source;
						$k_thumbarea = $height_source / $modcustom_merge_params['height'];
						$src_w = $modcustom_merge_params['width'] * $k_thumbarea;
						$src_x = ($width_source - $src_w) / 2; 
						
						$thumb_obj->set( 'src_w', $src_w );
						$thumb_obj->set( 'src_h', $src_h );
						$thumb_obj->set( 'src_x', $src_x );

					}
					
				}
				
				
				
				if ($modcustom_merge_params['sizeon'] == 'none'){
					continue;
					$custom_thumb_url = $customfile;
				}else{
					$customthumbsfiles = $thumb_obj->doThumbnail( $customfile );
					$custom_thumb_url = $customthumbsfiles[0];
				}
				


				$thumbsfiles = $thumb_obj->doThumbnail( $file );
				
			
					
				

				if (isset($img['title'])){
					$attribs['title'] = $img['title'];
					unset($img['title']);
				} else {
					$attribs['title'] = $img_alt;
				}
				
				
				$thumb_img = JHTML::_( 'image', $custom_thumb_url, $img_alt, $img);
				
				if ($typeBigThumbs != 'thumb'){
					$source_url = $thumbsfiles[1];

				}
				
				if (!empty($lightboxHandler)){
					$attribs[$lightboxHandler] = "$attribValue";
					if ($addarticleoption == 'slimbox'){
						$attribs[$lightboxHandler] .= '-module';
					}
					if ($addarticleoption == 'widgetkit'){
						$attribs[$lightboxHandler] .= ';group:module;';
					}
				}
				
				$thumb_a = JHTML::_( 'link', $source_url, $thumb_img, $attribs );
			



				
				$article->text 	= str_replace( $matches[0][$i], $thumb_a, $article->text );
			}
		}
		
        /**
        * Plugin that make thumbnails within content
        */

        public function onContentPrepare($context, &$article, &$params, $limitstart)
        {

			$thumbModcustom = $this->params->get( 'thumbModcustom', 0);

			$forModule = ($thumbModcustom ? ($context != 'mod_custom.content') : true);
			
			$app = JFactory::getApplication();
			if ( $app->isAdmin() ){
				return;
			}
			
			if ( $this->isBlog() && $forModule ) {
				return;		
			}
			
			if ( !isset($article->id) && $forModule ) {
				return;		
			}
			$this->onPrepareContent ( $context, $article, $params, $limitstart);
		}
		
		

		private function prepareThumbArticleParams(&$article)
        {
			
				
			$thumb_obj = new JdvThumbs2;
			
			$view = JRequest::getVar( 'view', '', 'GET', 'STRING' );



			$prefix = 'thumb-comp';
			$optionsIndex = 'category';

			if ($view == 'article'){
				$optionsIndex = $this->params->get( 'articleSetsFrom', 'article');	
			}
			if ($view == 'category'){
				$optionsIndex = $this->params->get( 'defaultSetsFrom', 'category');
			}
			if ($view == 'featured'){
				$optionsIndex = $this->params->get( 'featuredSetsFrom', 'featured');
			}

			if ($optionsIndex == 'article'){
				$prefix = 'thumb';
			}
			if ($optionsIndex == 'category'){
				$prefix = 'thumb-cat';
			}
			if ($optionsIndex == 'featured'){
				$prefix = 'thumb-fp';
			}
			
			/* featured */
			$width['featured'] = $this->params->get( 'widthForFeatured', 200);
			$height['featured'] = $this->params->get( 'heightForFeatured', 200);
			$sizeon['featured'] = $this->params->get( 'sizeonForFeatured', 'both' );
			
			/* categories */
			$width['category'] = $this->params->get( 'widthDefault', 200);
			$height['category'] = $this->params->get( 'heightDefault', 200);
			$sizeon['category'] = $this->params->get( 'sizeonDefault', 'both' );


			/* articles */
			$width['article'] = $this->params->get( 'widthForArticles', 200 );
			$height['article'] = $this->params->get( 'heightForArticles', 200 );
			$sizeon['article'] = $this->params->get( 'sizeonForArticles', 'both' );
			$media['article'] = $this->params->get( 'mediaForArticles', 'slimbox' );
			
			
			$width['intro_image'] = $width[$optionsIndex];
			$height['intro_image'] = $height[$optionsIndex];
			$sizeon['intro_image'] = $sizeon[$optionsIndex];




			
			/*if ($view == 'featured'){

				$width['intro_image'] = $this->params->get( 'widthForFeatured', 200);
				$height['intro_image'] = $this->params->get( 'heightForFeatured', 200);
				$sizeon['intro_image'] = $this->params->get( 'sizeonForFeatured', 'both' );
			}else{
				$width['intro_image'] = $this->params->get( 'widthDefault', 200);
				$height['intro_image'] = $this->params->get( 'heightDefault', 200);
				$sizeon['intro_image'] = $this->params->get( 'sizeonDefault', 'both' );
			}*/
			
			$Itemid = JRequest::getVar( 'Itemid', '', 'GET', 'INT' );
			
			$itemParams = jdvThumbsHelper::getItemidParams( $Itemid, $this->params );
			
			$intro_image_merge_params = array(
				'width'=>$width['intro_image'], 
				'height'=>$height['intro_image'], 
				'sizeon'=>$sizeon['intro_image']
			);
			
			jdvThumbsHelper::mergeParams( $intro_image_merge_params, $itemParams);
			
			/* общие */
			
			$quality = $this->params->get( 'quality', 90);
			$method = $this->params->get( 'method', 'resampled');
			$thumbArea = $this->params->get( 'thumbArea', 'top');
			$notumbSize = $this->params->get( 'notumbSize', 100);
			
			$thumbIntroImage = $this->params->get( 'thumbIntroImage', 1);
			
			
			$a = new JRegistry($article->images); //Load JSON string to Object
			if($thumbIntroImage == 2){
				$image_intro = $a->get('image_fulltext', '');
			}else{
				$image_intro = $a->get('image_intro', '');
			}
			
			
			list($width_source, $height_source) = @getimagesize($image_intro);
			if ($width_source < $notumbSize || $height_source < $notumbSize){
				return;
			}
			
			$fileBasename = JFile::getName($image_intro);
			$fileBasename = JFile::stripExt($fileBasename);
			
			$thumb_obj->set( 'prefix',  $prefix . '-' . $fileBasename );
					
			$thumb_obj->set( 'quality', $quality );
			$thumb_obj->set( 'method', $method );
			$thumb_obj->set( 'width',  $intro_image_merge_params['width'] );
			$thumb_obj->set( 'height', $intro_image_merge_params['height'] );
			$thumb_obj->set( 'sizeon', $intro_image_merge_params['sizeon'] );
			
			if ($thumbArea == 'middle' && $intro_image_merge_params['sizeon'] == 'crop'){
				$thumb_obj->set( 'sizeon', 'custom' );
				
				$k_source = $width_source / $height_source;
				$k_thumb = $intro_image_merge_params['width'] / $intro_image_merge_params['height'];
				
				
				if($k_thumb > $k_source){
					$src_w = $width_source;
					$k_thumbarea = $width_source / $intro_image_merge_params['width'];
					$src_h = $intro_image_merge_params['height'] * $k_thumbarea;
					$src_y = ($height_source - $src_h) / 2; 
					
					$thumb_obj->set( 'src_w', $src_w );
					$thumb_obj->set( 'src_h', $src_h );
					$thumb_obj->set( 'src_y', $src_y );

				}else{

					$src_h = $height_source;
					$k_thumbarea = $height_source / $intro_image_merge_params['height'];
					$src_w = $intro_image_merge_params['width'] * $k_thumbarea;
					$src_x = ($width_source - $src_w) / 2; 
					
					$thumb_obj->set( 'src_w', $src_w );
					$thumb_obj->set( 'src_h', $src_h );
					$thumb_obj->set( 'src_x', $src_x );

				}
				
			}

			$thumbsfiles = $thumb_obj->doThumbnail( $image_intro );
			
			$a->set('image_intro', $thumbsfiles[0]); //Replace fill image with $thumbnail
			$article->images = $a->toString(); //Save new data to the $article object
		}
		
		
}