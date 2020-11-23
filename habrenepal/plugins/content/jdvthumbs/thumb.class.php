<?php
/**
 * JdvThumbs Class
 * 
 */
// no direct access
defined('_JEXEC') or die('Restricted access');

class JdvThumbs
{
	var $_thumbParams;

	function __construct()
	{
		$this->_thumbParams['width'] = 200;
		$this->_thumbParams['height'] = 200;
		$this->_thumbParams['quality'] = 100;
		$this->_thumbParams['method'] = 'resized';
		$this->_thumbParams['areacrop'] = 'none';
		$this->_thumbParams['alpha'] = 0;
		$this->_thumbParams['thumbtype'] = 'jpg';
		$this->_thumbParams['sizeon'] = 'both';
		
		$this->_thumbParams['prefix'] = 'thumb';
		
		$this->_thumbParams['thumbsdir'] = 'cache/plg_jdvthumbs';
		$this->_thumbParams['showlogo'] = 0;
		$this->_thumbParams['logosrc'] = 'images/powered_by.png';
		$this->_thumbParams['logoposition'] = 'lefttop';
		$this->_thumbParams['replace'] = 0;
		$this->_thumbParams['md5'] = 1;
		
		
		
		$this->_thumbParams['src_x'] = 0;
		$this->_thumbParams['src_y'] = 0;
		$this->_thumbParams['src_w'] = 0;
		$this->_thumbParams['src_h'] = 0;
		
	}
	
	function set($param, $value){
		$this->_thumbParams[$param] = $value;
	}
	
	function get($param){
		return $this->_thumbParams[$param];
	}
	
	function doThumbnail( $files, $is_abs=false )
	{
		//global $mainframe;
		
		
		
		extract($this->_thumbParams);

		
		
		

		
		
		$files_thumb = array();
		$files_src = array();
		
		$thumbsdir = str_replace( array('/', '\\'), DS, $thumbsdir );
		$path_dest = JPATH_ROOT . DS . $thumbsdir;
		
		
		

		$n		= count( $files );
		
		if (is_array($files))
		foreach ($files as &$file) {
		

			if (!$is_abs){

			}else{
				$file = str_replace( DS, '/', $file );
				//$file = str_replace( array('/', '\\'), DS, $file );
				
				$file = str_replace( JPATH_ROOT, '', $file );
				/* $file_url = str_replace( DS, '/', $file_url ); */

			} 

			
			//echo md5( $file );
//echo $file;
			$filename = basename( $file );
			$file_ext = $this->getFileExt( $filename );
			
			if ($thumbtype == 'jpg'){
				$thumb_ext = 'jpg';
			}else{
				$thumb_ext = $file_ext;
			}
			
			$array_ext = array('jpg', 'png');
			if (!in_array($file_ext, $array_ext)){
				continue;
			}
			unset($array_ext);
		
			
			
			
			
			$files_src[] = $file;
			
			
			

			if (!is_file($file)) {
				//$n--;
				//continue;
			}
			
	
			if (substr($file,0,1) == '/'){
				$file = substr($file,1);
			}
			
			$files_thumb[] = $path_dest . DS . $prefix . ($md5 ? '-' . @md5( $file ) : '') . '.' . $thumb_ext;
			
			if ($this->chkCache( $file, $prefix, $thumb_ext, $replace, $md5 )) {
				$n--;
				continue;
			}
			
			
			
			// Get new sizes
			list($width_source, $height_source) = @getimagesize($file);
			if ($width_source == 0 || $height_source == 0) {
				continue;
			}
			
			switch ($sizeon) {
			case 'width':
				$new_width = $width;
				$percent = $width / $width_source;
				$new_height = $height_source * $percent;
				break;
				
			case 'height':
				$new_height = $height;
				$percent = $height / $height_source;
				$new_width = $width_source * $percent;
				break;
			
			case 'crop':
				if (($width / $height) > ($width_source / $height_source)){
					$new_width = $width;
					$percent = $width / $width_source;
					$new_height = $height_source * $percent;
				} else {
					$new_height = $height;
					$percent = $height / $height_source;
					$new_width = $width_source * $percent;	
				}
				break;
				
			default:
				if (($width / $height) < ($width_source / $height_source)){
					$new_width = $width;
					$percent = $width / $width_source;
					$new_height = $height_source * $percent;
				} else {
					$new_height = $height;
					$percent = $height / $height_source;
					$new_width = $width_source * $percent;
				}

			}

			if (($new_width < $width_source && $new_height < $height_source)) {
				$thumb = imagecreatetruecolor($new_width, $new_height );
				
				
			} else {
			//echo ($thumbtype == 'jpg' && $file_ext != $thumbtype);
			//exit;
				if ($thumbtype == 'jpg' && $file_ext != $thumbtype || ($showlogo && file_exists($logosrc))) {
					$new_width = $width_source;
					$new_height = $height_source;
					$thumb = imagecreatetruecolor($new_width, $new_height );
				}else{
					if (!copy( $file, $path_dest . DS . $prefix . ($md5 ? '-' . @md5( $file ) : '') . '.' . $thumb_ext)) {
						$n--;
					}
					continue;
				}
							
			}
				
			switch ($file_ext) {
			case 'jpg':
				//ini_set("memory_limit", "64M");
				$source = @imagecreatefromjpeg($file);

				break;
			case 'png':
				$source = @imagecreatefrompng($file);
				break;
			}
			if ($alpha && $file_ext == 'png'){
				imagealphablending($thumb, false);
				imagesavealpha($thumb, true);
			}
			
			
			if ($method == 'resampled'){
				// Resampled
				
				switch ($sizeon){

				case 'crop':
					$thumb_tmp = imagecreatetruecolor( $new_width, $new_height );
					imagecopyresampled($thumb_tmp, $source, 0, 0, 0, 0, $new_width, $new_height, $width_source, $height_source);
					$thumb = imagecreatetruecolor($width, $height);
					imageCopy($thumb, $thumb_tmp, 0, 0, 0, 0, $width, $height);
					imagedestroy($thumb_tmp);
					
					break;

					

				case 'custom':
				
					if ($areacrop == 'middle'){
						$area = $this->getAreaMiddle($file, array('width'=>$width, 'height'=>$height));
						extract($area);
					}
					$thumb_tmp = imagecreatetruecolor( $width, $height );

					imagecopyresampled($thumb_tmp, $source, 0, 0, $src_x, $src_y, $width, $height, $src_w, $src_h);

					$thumb = imagecreatetruecolor($width, $height);

					imageCopy($thumb, $thumb_tmp, 0, 0, 0, 0, $width, $height);

					imagedestroy($thumb_tmp);
					
					break;
				default:
					imagecopyresampled($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width_source, $height_source);
					
				}
			} else{
			
				// Resized
				switch ($sizeon){

				case 'crop':
					$thumb_tmp = imagecreatetruecolor( $new_width, $new_height );
					
					imagecopyresized($thumb_tmp, $source, 0, 0, 0, 0, $new_width, $new_height, $width_source, $height_source);
					$thumb = imagecreatetruecolor($width, $height);
					imageCopy($thumb, $thumb_tmp, 0, 0, 0, 0, $width, $height);
					imagedestroy($thumb_tmp);
					break;
					
				case 'custom':
					if ($areacrop == 'middle'){
						$area = $this->getAreaMiddle($file, array('width'=>$width, 'height'=>$height));
						extract($area);
					}
					$thumb_tmp = imagecreatetruecolor( $width, $height );

					imagecopyresized($thumb_tmp, $source, 0, 0, $src_x, $src_y, $width, $height, $src_w, $src_h);

					$thumb = imagecreatetruecolor($width, $height);

					imageCopy($thumb, $thumb_tmp, 0, 0, 0, 0, $width, $height);

					imagedestroy($thumb_tmp);
					
					break;
					
				default:
					imagecopyresized($thumb, $source, 0, 0, 0, 0, $new_width, $new_height, $width_source, $height_source);
					
				}
			}
			
			
			if($showlogo && file_exists($logosrc)){
			
				$logo_ext = $this->getFileExt( basename($logosrc ) );
				
				if ($logo_ext == 'png'){
					$thumb_tmp = imagecreatefrompng($logosrc);
					/* imagealphablending($thumb_tmp, false);
					imagesavealpha($thumb_tmp, true); */
				}
				if ($logo_ext == 'jpg'){
					$thumb_tmp = imagecreatefromjpg($logosrc);
				}

				list($logo_width, $logo_height) = getimagesize($logosrc);
				
				$logoposition_x = 0;
				$logoposition_y = 0;
				
				if ($logoposition == 'righttop'){
					$logoposition_x = $new_width - $logo_width;
					$logoposition_y = 0;
				}
				if ($logoposition == 'rightbottom'){
					$logoposition_x = $new_width - $logo_width;
					$logoposition_y = $new_height - $logo_height;
				}
				if ($logoposition == 'leftbottom'){
					$logoposition_x = 0;
					$logoposition_y = $new_height - $logo_height;
				}
				
				imageCopy($thumb, $thumb_tmp, $logoposition_x, $logoposition_y, 0, 0, $logo_width, $logo_height);
				
				if (isset($thumb_tmp)){
					imagedestroy($thumb_tmp);
				}
			}
			
			
			switch ($thumb_ext) {
			case 'jpg':
			
				// Set the content prefix header - in this case image/jpeg
				header('Content-prefix: image/jpeg');
				break;
			case 'png':
				header('Content-prefix: image/png');
				break;
			default:
				$n--;
				continue 2;
				break;
			}

			
			// Output
			switch ($thumb_ext) {
			case 'jpg':
				@imagejpeg($thumb, $path_dest . DS . $prefix . ($md5 ? '-' . @md5( $file ) : '') . '.' . $thumb_ext, $quality);
				break;
			case 'png':
				$q = ($quality - 10) / 100;
				@imagepng($thumb, $path_dest . DS . $prefix . ($md5 ? '-' . @md5( $file ) : '') . '.' . $thumb_ext, $q, PNG_ALL_FILTERS );
				break;
			}


			// Free up memory
			imagedestroy($thumb);
			imagedestroy($source);
			
			
		}

		return array( $files_thumb, $files_src );
	} // end function doThumbnail	
	
	
	function chkCache( $file, $prefix, $thumb_ext, $replace, $md5 )
	{
		$filename = basename( $file );
		
		$hash = ($md5 ? '-' . @md5( $file ) : '');
		
		$thumbsdir = $this->get( 'thumbsdir' );

		$thumbsdir = str_replace( array('/', '\\'), DS, $thumbsdir );
		$path_dest = JPATH_ROOT . DS . $thumbsdir;
		
		if (!JFolder::exists($path_dest)) {
			//JFolder::create($path_dest, '0755');
			JFolder::create($path_dest);
		}
		
		$cachefile = $path_dest . DS . $prefix . $hash . '.' . $thumb_ext;
		
		if (!$replace)
		if (is_file( $cachefile )) {
			return true;
		}
		
		return false;
	}
	
	
	function getFileExt( $filename )
	{
		$file_extension = strtolower(substr(strrchr($filename,"."),1));
		return $file_extension;
	}
	
	
	function getAreaMiddle( $src, $dest )
	{
		$area = array();
		/* echo $src;
		exit; */
		list($width_source, $height_source) = @getimagesize($src);
		
		//if ($thumbArea == 'middle' && $dest['sizeon'] == 'crop'){
			//$thumb_obj->set( 'sizeon', 'custom' );
			
			$k_source = $width_source / $height_source;
			$k_thumb = $dest['width'] / $dest['height'];
			
			
			if($k_thumb > $k_source){
				$src_w = $width_source;
				$k_thumbarea = $width_source / $dest['width'];
				$src_h = $dest['height'] * $k_thumbarea;
				$src_y = ($height_source - $src_h) / 2; 
				
				$area = array('src_w'=>$src_w, 'src_h'=>$src_h, 'src_y'=>$src_y);


			}else{

				$src_h = $height_source;
				$k_thumbarea = $height_source / $dest['height'];
				$src_w = $dest['width'] * $k_thumbarea;
				$src_x = ($width_source - $src_w) / 2; 
				
				$area = array('src_w'=>$src_w, 'src_h'=>$src_h, 'src_x'=>$src_x);

			}
			
		//}
		return $area;
	}
	
	
	function getURL( $filename )
	{
		if (strpos($filename, 'http://') !== false) return $filename;
		$path_from_base = str_replace(JPATH_SITE . DS, '', $filename);
		
		$juri_base = JURI::root();
		
		$path_from_base = str_replace($juri_base, '', $path_from_base);
		$url = str_replace( DS, '/', $path_from_base );
		$url = $juri_base . $url;
		
		return $url;
	}
}
?>