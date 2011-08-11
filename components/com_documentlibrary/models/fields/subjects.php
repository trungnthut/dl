<?php

defined ('_JEXEC') or die ('Access denied');

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldSubjects extends JFormFieldList {
	protected $type = 'subjects';
	
	function __construct() {
		$language =& JFactory::getLanguage();
		$extension = 'com_documentlibrary';
		$base_dir = JPATH_SITE . '/components/com_documentlibrary';
		$language_tag = $language->getTag(); // loads the current language-tag
		$language->load($extension, $base_dir, $language_tag, true);
	}
	
	protected function getOptions() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('subject_id, name');
		$query->from('#__document_subjects');
		$db->setQuery($query);
		
		$subjects = $db->loadObjectList();
		
		$options = array();
		if (!empty($subjects)) {
			foreach ($subjects as $subject) {
				$options[] = JHtml::_('select.option', $subject->subject_id, JText::_($subject->name));
			}
		}
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>