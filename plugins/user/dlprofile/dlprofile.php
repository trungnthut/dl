<?php
/**
 * @version		$Id: profile.php 21097 2011-04-07 15:38:03Z dextercowley $
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;
jimport('joomla.utilities.date');

/**
 * An example custom profile plugin.
 *
 * @package		Joomla.Plugin
 * @subpackage	User.profile
 * @version		1.6
 */
class plgUserDlProfile extends JPlugin
{
	/**
	 * @param	string	$context	The context for the data
	 * @param	int		$data		The user id
	 * @param	object
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareData($context, $data)
	{
		// Check we are manipulating a valid form.
		if (!in_array($context, array('com_users.profile','com_users.user', 'com_users.registration', 'com_admin.profile'))) {
			return true;
		}

		if (is_object($data))
		{
			$userId = isset($data->id) ? $data->id : 0;

			// Load the profile data from the database.
			$db = JFactory::getDbo();
			$db->setQuery(
				'SELECT profile_key, profile_value FROM #__user_profiles' .
				' WHERE user_id = '.(int) $userId." AND profile_key LIKE 'profile.%'" .
				' ORDER BY ordering'
			);
			$results = $db->loadRowList();

			// Check for a database error.
			if ($db->getErrorNum())
			{
				$this->_subject->setError($db->getErrorMsg());
				return false;
			}

			// Merge the profile data.
			$data->profile = array();

			foreach ($results as $v)
			{
				$k = str_replace('profile.', '', $v[0]);
				$data->profile[$k] = $v[1];
			}
			if (!JHtml::isRegistered('users.url')) {
				JHtml::register('users.url', array(__CLASS__, 'url'));
			}
			if (!JHtml::isRegistered('users.calendar')) {
				JHtml::register('users.calendar', array(__CLASS__, 'calendar'));
			}
			if (!JHtml::isRegistered('users.tos')) {
				JHtml::register('users.tos', array(__CLASS__, 'tos'));
			}
			if (!JHtml::isRegistered('users.degree')) {
				JHtml::register('users.degree', array(__CLASS__, 'degree'));
			}
			if (!JHtml::isRegistered('users.subject')) {
				JHtml::register('users.subject', array(__CLASS__, 'subject'));
			}
			if (!JHtml::isRegistered('users.anchor')) {
				JHtml::register('user.anchor', array(__CLASS__, 'anchor'));
			}
		}

		return true;
	}

	public static function url($value)
	{
		if (empty($value))
		{
			return JHtml::_('users.value', $value);
		}
		else
		{
			$value = htmlspecialchars($value);
			if(substr ($value, 0, 4) == "http") {
				return '<a href="'.$value.'">'.$value.'</a>';
			}
			else {
				return '<a href="http://'.$value.'">'.$value.'</a>';
			}
		}
	}

	public static function calendar($value)
	{
		if (empty($value)) {
			return JHtml::_('users.value', $value);
		} else {
			return JHtml::_('date', $value);
		}
	}

	public static function tos($value)
	{
		if ($value) {
			return JText::_('JYES');
		}
		else {
			return JText::_('JNO');
		}
	}
	
	public static function degree($value) {
		$values= array();
		$values[1] = "PLG_USER_DLPROFILE_FIELD_DEGREE_BACHELOR_OPTION";
		$values[2] = "PLG_USER_DLPROFILE_FIELD_DEGREE_MASTER_OPTION";
		$values[3] = "PLG_USER_DLPROFILE_FIELD_DEGREE_DOCTOR_OPTION";
		if (empty($value)) {
			return JHtml::_('users.value', $value);
		}
		if (array_key_exists($value, $values)) {
			return JText::_($values[$value]);
		}
		return JText::_($value);
	} 
	
	public static function subject($value) {
		if (empty($value)) {
			return JHtml::_('users.value', $value);
		}
		static $languageLoaded = false;
		if (!$languageLoaded) {
			$language =& JFactory::getLanguage();
			$extension = 'com_documentlibrary';
			$base_dir = JPATH_SITE . '/components/com_documentlibrary';
			$language_tag = $language->getTag(); // loads the current language-tag
			$language->load($extension, $base_dir, $language_tag, true);
			$languageLoaded = true;
		}
		$db = JFactory::getDbo();
		$query = 'SELECT name FROM #__document_subjects WHERE subject_id = ' . $value;
		$db->setQuery($query);
		$name = $db->loadResult();
		return JText::_($name);
	}

	public static function anchor($value) {
		// if (empty($value)) {
			// return '';
		// }
		if ($value == 1) {
			return '<a href="index.php?option=com_documentlibrary&view=userContrib">contrib</a>';
		}
		else {
			return '<a href="index.php?option=com_documentlibrary&view=userDownloads">downloads</a>';
		}
	}
	/**
	 * @param	JForm	$form	The form to be altered.
	 * @param	array	$data	The associated data for the form.
	 *
	 * @return	boolean
	 * @since	1.6
	 */
	function onContentPrepareForm($form, $data)
	{
		// Load user_profile plugin language
		$lang = JFactory::getLanguage();
		$lang->load('plg_user_dlprofile', JPATH_ADMINISTRATOR);

		if (!($form instanceof JForm))
		{
			$this->_subject->setError('JERROR_NOT_A_FORM');
			return false;
		}

		// Check we are manipulating a valid form.
		if (!in_array($form->getName(), array('com_admin.profile','com_users.user', 'com_users.registration','com_users.profile'))) {
			return true;
		}

		// Add the registration fields to the form.
		JForm::addFormPath(dirname(__FILE__).'/profiles');
		$form->loadFile('profile', false);

		// Toggle whether the dob field is required.
		$this->toggleRequiredField('dob', 'dlprofile-require_dob', $form);
		
		// Toggle whether the sex field is required
		$this->toggleRequiredField('sex', 'dlprofile-require_sex', $form);
		
		// Toggle whether the degree field is required
		$this->toggleRequiredField('degree', 'dlprofile-require_degree', $form);
		
		// Toggle whether the subject field is required
		$this->toggleRequiredField('subject', 'dlprofile-require_subject', $form);
		
		// Toggle whether the award field is required
		$this->toggleRequiredField('award', 'dlprofile-require_award', $form);
		
		// Toggle whether the school field is required
		$this->toggleRequiredField('school', 'dlprofile-require_school', $form);
		
		// Toggle whether the district field is required.
		$this->toggleRequiredField('address1', 'dlprofile-require_address1', $form);

		// Toggle whether the city/provine field is required.
		$this->toggleRequiredField('address2', 'dlprofile-require_address2', $form);

		return true;
	}
	
	private function toggleRequiredField($field, $param, $form, $section = 'profile') {
		if (empty ($form)) {
			return;
		}
		if ($this->params->get($param, 1) > 0) {
			$form->setFieldAttribute($field, 'required', $this->params->get($param) == 2, $section);
		} else {
			$form->removeField($field, $section);
		}
	}

	function onUserAfterSave($data, $isNew, $result, $error)
	{
		$userId	= JArrayHelper::getValue($data, 'id', 0, 'int');

		if ($userId && $result && isset($data['profile']) && (count($data['profile'])))
		{
			try
			{
				//Sanitize the date
				if (!empty($data['profile']['dob'])) {
					$date = new JDate($data['profile']['dob']);
					$data['profile']['dob'] = $date->toFormat('%Y-%m-%d');
				}

				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'profile.%'"
				);

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}

				$tuples = array();
				$order	= 1;

				foreach ($data['profile'] as $k => $v)
				{
					$tuples[] = '('.$userId.', '.$db->quote('profile.'.$k).', '.$db->quote($v).', '.$order++.')';
				}

				$db->setQuery('INSERT INTO #__user_profiles VALUES '.implode(', ', $tuples));

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}

			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}

	/**
	 * Remove all user profile information for the given user ID
	 *
	 * Method is called after user data is deleted from the database
	 *
	 * @param	array		$user		Holds the user data
	 * @param	boolean		$success	True if user was succesfully stored in the database
	 * @param	string		$msg		Message
	 */
	function onUserAfterDelete($user, $success, $msg)
	{
		if (!$success) {
			return false;
		}

		$userId	= JArrayHelper::getValue($user, 'id', 0, 'int');

		if ($userId)
		{
			try
			{
				$db = JFactory::getDbo();
				$db->setQuery(
					'DELETE FROM #__user_profiles WHERE user_id = '.$userId .
					" AND profile_key LIKE 'profile.%'"
				);

				if (!$db->query()) {
					throw new Exception($db->getErrorMsg());
				}
			}
			catch (JException $e)
			{
				$this->_subject->setError($e->getMessage());
				return false;
			}
		}

		return true;
	}
}
