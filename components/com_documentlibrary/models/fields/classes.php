<?php

defined ('_JEXEC') or die ('Access denied');

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('list');

class JFormFieldClasses extends JFormFieldList {
	protected $type = 'classes';
	private $fixedData;
    private $lastFixedId;
    private $displayData;
	
	function __construct() {
		$language =& JFactory::getLanguage();
		$extension = 'com_documentlibrary';
		$base_dir = JPATH_SITE . '/components/com_documentlibrary';
		$language_tag = $language->getTag(); // loads the current language-tag
		$language->load($extension, $base_dir, $language_tag, true);
		
		// classes array
		$this->fixedData = array(
            1 => 10,
            2 => 11,
            3 => 12,
            4 => -1
        );
        
        $this->lastFixedId = count($this->fixedData);
        
        foreach ($this->fixedData as $id => $class) {
        	if ($class > 0) {
            	$className = JText::_('COM_DOCUMENT_LIBRARY_MODEL_CLASSES_CLASS_PREFIX') . ' ' . $class;
			} else {
				$className = JText::_('COM_DOCUMENT_LIBRARY_MODEL_CLASSES_OTHER_CLASS');
			}
            $this->displayData[$id] = $className;
        }
	}
	
	protected function getOptions() {		
		$options = array();
			foreach ($this->displayData as $id => $class) {
				$options[] = JHtml::_('select.option', $id, JText::_($class));
			}
		
		$options = array_merge(parent::getOptions(), $options);
		return $options;
	}
}

?>