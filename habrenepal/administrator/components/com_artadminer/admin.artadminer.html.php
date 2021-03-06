<?php
/**
* @module		Art Adminer
* @copyright	Copyright (C) 2013 artetics.com
* @license		GPL
*/
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
error_reporting(E_ERROR);

class HTML_ArtAdminer {
	
	function settings($option, &$row) {
		HTML_ArtAdminer::setSettingsToolbar();
		
		?>
    <style>
    fieldset label {
      clear: none !important;
    }

    fieldset.adminform label {
      width: auto !important;
      margin-right: 10px !important;
    }

    .admintable input {
      float: none !important;
    }

    .admintable select {
      float: none !important;
    }

    fieldset.adminform label {
      clear: none !important;
      float: none !important;
      display: inline;
    }
    </style>
		<form action="index.php" method="post" name="adminForm">
			<div class="col100" id="editForm">
			<fieldset class="adminform">
			<table class="admintable">
				<tbody>
					<tr>
						<td width="20%" class="key" title="Auto login. When set adminer will automatically connect to database using credentials stored in Joomla!">
							<label for="autologin">Auto login</label>
						</td>
						<td>
							<?php echo JHTML::_('select.booleanlist',  'autologin', '', $row->autologin ); ?>
						</td>
					</tr>
				</tbody>
			</table>
			<input type="hidden" name="option" value="<?php echo $option; ?>" />
			<input type="hidden" name="task" value="settings" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="id" value="1" />
		</form>
		<?php
	}
	
	function adminer($option) {
		HTML_ArtAdminer::setAdminerToolbar();
		$row =& JTable::getInstance('artadminer_setting', 'Table');
					
		$row->load(1);
		$adminerUrl = JURI::base() . 'components/' . $option . '/adminer.php';
		$cfg = new JConfig();
		if ($row->autologin) {
			$adminerUrl .= '?server=' . $cfg->host . '&username=' . $cfg->user;
		}
		
		?>
		<iframe style="width:100%;height:1000px; border: none;" src="<?php echo $adminerUrl; ?>"></iframe>
		<?php
	}

	function setAdminerToolbar() {
	}
	
	function setSettingsToolbar() {
		JToolBarHelper::title('Settings', 'config.png');
		JToolBarHelper::custom('settings_save', 'save.png', 'default.png', 'Save', false);
		JToolBarHelper::custom('settings', 'cancel.png', 'default.png', 'Cancel', false);
	}
	
}


?>