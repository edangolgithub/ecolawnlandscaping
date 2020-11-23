<?php
/**
 * @package         UserIdeas
 * @subpackage      Plugins
 * @author          Todor Iliev
 * @copyright       Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license         http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

/**
 * This plugin send notification mails to the administrator.
 *
 * @package        UserIdeas
 * @subpackage     Plugins
 */
class plgContentUserIdeasAdminMail extends JPlugin
{
    /**
     * A JRegistry object holding the parameters for the plugin
     *
     * @var    Joomla\Registry\Registry
     * @since  1.5
     */
    public $params = null;

    /**
     * This method is executed when someone create an item.
     *
     * @param string             $context
     * @param UserIdeasTableItem $row
     * @param boolean            $isNew
     *
     * @return void|boolean
     */
    public function onContentAfterSave($context, $row, $isNew)
    {
        $app = JFactory::getApplication();
        /** @var $app JApplicationSite */

        if ($app->isAdmin()) {
            return null;
        }

        if (strcmp("com_userideas.form", $context) != 0) {
            return null;
        }

        $emailId = $this->params->get("send_when_post_email_id", 0);

        // Check for enabled option for sending mail
        // when user create a item.
        if (!empty($emailId)) {

            if ($isNew and !empty($row->id)) {

                $success = $this->sendMail($emailId, $row->getTitle(), $row->getSlug(), $row->getCategorySlug());
                if (!$success) {
                    return false;
                }

            }

        }

        return true;
    }

    /**
     * This method is executed when someone sends a comment.
     *
     * @param string             $context
     * @param UserIdeasTableItem $row
     * @param boolean            $isNew
     *
     * @return null|boolean
     */
    public function onCommentAfterSave($context, $row, $isNew)
    {
        $app = JFactory::getApplication();
        /** @var $app JApplicationSite */

        if ($app->isAdmin()) {
            return null;
        }

        if (strcmp("com_userideas.comment", $context) != 0) {
            return null;
        }

        $emailId = $this->params->get("post_comment_email_id", 0);

        // Check for enabled option for sending mail
        // when user sends a comment.
        if (!empty($emailId)) {

            if ($isNew and !empty($row->id)) {

                jimport("userideas.item");
                $item = new UserIdeasItem(JFactory::getDbo());
                $item->load($row->get("item_id"));

                $success = $this->sendMail($emailId, $item->getTitle(), $item->getSlug(), $item->getCategorySlug());
                if (!$success) {
                    return false;
                }
            }

        }

        return true;
    }

    protected function sendMail($emailId, $title, $itemId, $categoryId)
    {
        $result = true;
        $this->loadLanguage();

        $app = JFactory::getApplication();
        /** @var $app JApplicationSite */

        $uri     = JUri::getInstance();
        $website = $uri->toString(array("scheme", "host"));

        $data = array(
            "site_name"      => $app->get("sitename"),
            "site_url"       => JUri::root(),
            "item_title"     => $title,
            "item_url"       => $website . JRoute::_(UserIdeasHelperRoute::getDetailsRoute($itemId, $categoryId)),
        );

        jimport("userideas.email");
        $email = new UserIdeasEmail();
        $email->setDb(JFactory::getDbo());
        $email->load($emailId);

        // Set sender name and email.
        if (!$email->getSenderName()) {
            $email->setSenderName($app->get("fromname"));
        }
        if (!$email->getSenderEmail()) {
            $email->setSenderEmail($app->get("mailfrom"));
        }

        // Prepare recipient data.
        $componentParams = JComponentHelper::getParams("com_userideas");
        /** @var  $componentParams Joomla\Registry\Registry */

        $recipientId = $componentParams->get("administrator_id");
        if (!empty($recipientId)) {
            $recipient = JFactory::getUser($recipientId);
            $recipientName = $recipient->get("name");
            $recipientMail = $recipient->get("email");
        } else {
            $recipientName = $app->get("fromname");
            $recipientMail = $app->get("mailfrom");
        }

        // Prepare data for parsing
        $data["sender_name"]     = $email->getSenderName();
        $data["sender_email"]    = $email->getSenderEmail();
        $data["recipient_name"]  = $recipientName;
        $data["recipient_email"] = $recipientMail;

        $emailMode = $this->params->get("email_mode", "plain");

        // Parse data
        $email->parse($data);
        $subject = $email->getSubject();
        $body    = $email->getBody($emailMode);

        $mailer = JFactory::getMailer();
        if (strcmp("html", $emailMode) == 0) { // Send as HTML message
            $return = $mailer->sendMail($email->getSenderEmail(), $email->getSenderName(), $recipientMail, $subject, $body, UserIdeasConstants::MAIL_MODE_HTML);
        } else { // Send as plain text.
            $return = $mailer->sendMail($email->getSenderEmail(), $email->getSenderName(), $recipientMail, $subject, $body, UserIdeasConstants::MAIL_MODE_PLAIN);
        }

        // Check for an error.
        if ($return !== true) {
            $error = JText::_("PLG_CONTENT_USERIDEASADMINMAIL_ERROR_MAIL_SENDING_USER");
            JLog::add($error);
            $result = false;
        }

        return $result;
    }
}
