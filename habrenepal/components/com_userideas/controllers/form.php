<?php
/**
 * @package      UserIdeas
 * @subpackage   Component
 * @author       Todor Iliev
 * @copyright    Copyright (C) 2014 Todor Iliev <todor@itprism.com>. All rights reserved.
 * @license      http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

// no direct access
defined('_JEXEC') or die;

jimport('itprism.controller.form.frontend');

/**
 * UserIdeas form controller
 *
 * @package     UserIdeas
 * @subpackage  Component
 */
class UserIdeasControllerForm extends ITPrismControllerFormFrontend
{
    /**
     * Method to get a model object, loading it if required.
     *
     * @param    string $name   The model name. Optional.
     * @param    string $prefix The class prefix. Optional.
     * @param    array  $config Configuration array for model. Optional.
     *
     * @return    object    The model.
     * @since    1.5
     */
    public function getModel($name = 'Form', $prefix = 'UserIdeasModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);

        return $model;
    }

    public function save($key = null, $urlVar = null)
    {
        // Check for request forgeries.
        JSession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

        // Get the data from the form POST
        $data   = $this->input->post->get('jform', array(), 'array');
        $itemId = JArrayHelper::getValue($data, "id", 0, "int");

        $redirectOptions = array(
            "view" => "form",
            "id"   => $itemId
        );

        // Check for valid user
        $user   = JFactory::getUser();
        $userId = $user->get("id");

        if (!$this->allowSave($data)) {
            $redirectOptions = array(
                "force_direction" => "index.php?option=com_users&view=login"
            );
            $this->displayNotice(JText::_('COM_USERIDEAS_ERROR_NO_PERMISSIONS_TO_DO_ACTION'), $redirectOptions);

            return;
        }

        // Get params
        $params = JComponentHelper::getParams("com_userideas");

        $model = $this->getModel();
        /** @var $model UserIdeasModelForm */

        $form = $model->getForm($data, false);
        /** @var $form JForm */

        if (!$form) {
            throw new Exception(JText::_("COM_USERIDEAS_ERROR_FORM_CANNOT_BE_LOADED"), 500);
        }

        // Test if the data is valid.
        $validData = $model->validate($form, $data);

        // Check for validation errors.
        if ($validData === false) {
            $this->displayNotice($form->getErrors(), $redirectOptions);

            return;
        }

        try {

            // Set the user ID.
            if (!empty($itemId) and empty($validData["user_id"])) {
                $validData["user_id"] = (int)$userId;
            }

            $itemId                = $model->save($validData);

            $redirectOptions["id"] = $itemId;

        } catch (Exception $e) {

            JLog::add($e->getMessage());
            throw new Exception(JText::_('COM_USERIDEAS_ERROR_SYSTEM'));

        }

        $redirectOptions = array(
            "force_direction" => (!$userId or (strcmp("list", $params->get("redirect_when_post")) == 0)) ?
                    UserIdeasHelperRoute::getItemsRoute() :
                    UserIdeasHelperRoute::getFormRoute($itemId)
        );

        // Redirect to next page
        $this->displayMessage(JText::_('COM_USERIDEAS_ITEM_SAVED_SUCCESSFULLY'), $redirectOptions);

    }

    /**
     * Method override to check if you can add a new record.
     *
     * @param   array $data An array of input data.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowAdd($data = array())
    {
        $user  = JFactory::getUser();

        if ($user->authorise('core.create', 'com_userideas')) {
            return true;
        }

        return false;
    }

    /**
     * Method override to check if you can edit an existing record.
     *
     * @param   array  $data An array of input data.
     * @param   string $key  The name of the key for the primary key; default is id.
     *
     * @return  boolean
     *
     * @since   1.6
     */
    protected function allowEdit($data = array(), $key = 'id')
    {
        $user     = JFactory::getUser();

        // Validate action role.
        if (!$user->authorise('core.edit.own', 'com_userideas')) {
            return false;
        }

        // Validate item owner.
        $itemId = JArrayHelper::getValue($data, $key);
        $userId = $user->get("id");

        // Validate item owner.
        jimport("userideas.validator.item.owner");
        $itemValidator = new UserIdeasValidatorItemOwner(JFactory::getDbo(), $itemId, $userId);
        if (!$itemValidator->isValid()) {
            return false;
        }

        return true;
    }
}
