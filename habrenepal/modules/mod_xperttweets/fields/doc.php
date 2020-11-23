<?php
/**
 * @package Expose
 * @subpackage Xpert Contents
 * @version 2.5
 * @author ThemeXpert http://www.themexpert.com
 * @copyright Copyright (C) 2009 - 2011 ThemeXpert
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// no direct access
defined( '_JEXEC' ) or die('Restricted access');

jimport('joomla.html.html');
jimport('joomla.form.formfield');

class JFormFieldDoc extends JFormField{

    protected $type = 'Doc';


    protected function getInput(){

        $title      = 'Documentation';
        $msg        = 'Please read this <a href="http://www.themexpert.com/documentation/joomla-extensions/xperttweets" target="_blank">documentation</a> to know more about creating access token and others';
        $html       = '';

        // Style
        $html .= '<style>
                    .xk-callout { margin: 10px 0; padding: 15px 30px 15px 15px; border-left: 5px solid #eee; }
                    .xk-callout h4 { margin-top: 0; }
                    .xk-callout p:last-child { margin-bottom: 0; }
                    .xk-callout-info { background-color: #f0f7fd; border-color: #d0e3f0; }
                    .xk-callout-danger { background-color: #fcf2f2; border-color: #dFb5b4; }
                 </style>';

        // cURL checking and issue a warning
        if (!in_array('curl', get_loaded_extensions())) 
        {
            $html .= '<div class="xk-callout xk-callout-danger">';
                $html .= '<h4>Heads up!</h4>';
                $html .= 'In order to get this module working you need to install cURL on your server. Checkout our tutorial for this.';
            $html .= '</div>';
        }

        $html .= '<div class="xk-callout xk-callout-info">';
            $html .= ($title) ? '<h4>' . JText::_($title) . '</h4>' : '';
            $html .= ($msg) ? '<p>' . JText::_($msg) . '</p>' : '';
        $html .= '</div>';

        return $html;
    }

    protected function getLabel(){
        return ;
    }
}
