<?php
/**
 * @package		Profiles
 * @subpackage	filemanger
 * @copyright	Copyright (C) 2013 - 2013 Mad4Media - Dipl. Informatiker(FH) Fahrettin Kutyol. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @license		Libraries can be under a different license in other environments
 * @license		Media files owned and created by Mad4Media such as 
 * @license 	Javascript / CSS / Shockwave or Images are licensed under GFML (GPL Friendly Media License). See GFML.txt.
 * @license		3rd party scripts are under the license of the copyright holder. See source header or license text file which is included in the appropriate folders
 * @version		1.0
 * @link		http://www.mad4media.de
 * Creation date 2013/02
 */

//CUSTOMPLACEHOLDER
//CUSTOMPLACEHOLDER2

defined('_JEXEC') or die;

class xhrplayer extends MTask{
	
	function _default(){
		//mp3
		$this->mp3();
	}
 
	function mp3(){
		//mp3
		
		if(! MRights::can("open")){
			return $this->_noAuth("open");
		}
		
		global $dir;
		$info = MFile::info($dir);
		$songname = str_replace("_"," ",str_replace(".mp3","",$info->baseName));
		$this->view->add2Content( 
			'<embed  name = "fullsceen" align="middle" flashvars="songname='.$songname.'&songurl='.urlencode(MURL::_("xhraudio",str_replace(_START_FOLDER, "",$dir))).
			'" src="'._FM_HOME_FOLDER.'/media/mp3player.swf" width="520" height="70" type="application/x-shockwave-flash"'.
			'pluginspage="http://www.macromedia.com/go/getflashplayer"  />'
			);
	}
	
	function flv(){
		
		if(! MRights::can("open")){
			return $this->_noAuth("open");
		}
		
		global $dir;
		$info = MFile::info($dir);		
		$this->view->add2Content(
			'<embed
			  type="application/x-shockwave-flash"
			  pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
			  width="550" height="400"
			  src="'._FM_HOME_FOLDER.'/media/JarisFLVPlayer.swf"
			  allowfullscreen="true" 
			  allowscriptaccess="always"
			  bgcolor="#000000"
			  quality="high"
			  scale="noscale"
			  wmode="opaque"
			  flashvars="source='.urlencode(_FM_ABSOLUTE_URI . MURL::_("xhrvideo",str_replace(_START_FOLDER, "",$dir))).'&controltype=1&type=video&streamtype=file&&autostart=true&hardwarescaling=false&darkcolor=000000&brightcolor=4c4c4c&controlcolor=FFFFFF&hovercolor=67A8C1"
			  seamlesstabbing="false"
			>
			  <noembed>
			  </noembed>
			</embed>'
		);
		
		
	}
	
	function swf(){
		
		if(! MRights::can("open")){
			return $this->_noAuth("open");
		}
		
		//swf
		global $dir;
		$info = MFile::info($dir);
		$songname = str_replace("_"," ",str_replace(".mp3","",$info->baseName));
		$this->view->add2Content( 
			'<center><embed name = "swfVideo" align="middle" '.
			'" src="'.MURL::_("xhrvideo",urlencode(str_replace(_START_FOLDER, "",$dir))).'" width ="100%" type="application/x-shockwave-flash"'.
			'pluginspage="http://www.macromedia.com/go/getflashplayer"  /></center>'
			);
	}	
	
	function object(){
		
		if(! MRights::can("open")){
			return $this->_noAuth("open");
		}
		
		//video
		global $dir;
		$info = MFile::info($dir);
		$this->view->add2Content( '<center>
		        <object align="middle"  type="'.getMimeType($dir).'" data="'.MURL::_("xhrvideo",urlencode(str_replace(_START_FOLDER, "",$dir))).'" width="750px" height="450px">
				</object></center>');
	}
	
	function image(){
		
		if(! MRights::can("open")){
			return $this->_noAuth("open");
		}
		
		global $dir;
		$this->view->add2Content('
		<center>
		<img src ="'.MURL::_("xhranyfile",urlencode(str_replace(_START_FOLDER, "",$dir))).'" style="max-width: 100%;"/>
		</center>
		');
	}
	
	
	protected function _noAuth($rule=null){
		$this->view->content('
				<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0"><tbody>
				<tr>
				<td align="center" valign="middle"><span class="noAuth">'.MRights::getError($rule,1).'</span></td>
				</tr>
				</tbody></table>
				');
	}
	
	
}



?>