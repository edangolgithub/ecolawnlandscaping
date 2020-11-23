<?php
/**
 * @package		Joomla.Site
 * @subpackage	Templates.beez_20
 * @copyright	Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access.
defined('_JEXEC') or die;

/**
 * beezDivision chrome.
 *
 * @since	1.6
 */
function modChrome_responsive($module, &$params, &$attribs)
{
	$headerLevel = isset($attribs['headerLevel']) ? (int) $attribs['headerLevel'] : 3;
	
	if (!empty ($module->content)) { ?>
		<div class="moduleContainer <?php if($params->get('moduleclass_sfx')) { echo htmlspecialchars($params->get('moduleclass_sfx')); } ?>">
            <div class="moduleContent">
                <?php if ($module->showtitle) { echo '<h'.$headerLevel.'>'.$module->title.'</h'.$headerLevel.'>';}; ?>
                <?php echo $module->content; ?>
           	</div> 
		</div>
<?php };
}?>