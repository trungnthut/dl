<?php
// No direct access to this file
defined('_JEXEC') or die;
 
// import the list field type
jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');
 
/**
 * HelloWorld Form Field class for the Subject component
 */
class JFormFieldSubject extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var		string
	 */
	protected $type = 'Subject';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return	array		An array of JHtml options.
	 */
	protected function getOptions() 
	{
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('subject_id,name');
		$query->from('#__document_subjects');
		$db->setQuery((string)$query);
		$messages = $db->loadObjectList();
		$options = array();
		if ($messages)
		{
			foreach($messages as $message) 
			{
				$options[] = JHtml::_('select.option', $message->subject_id, $message->name);
			}
		}
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}
