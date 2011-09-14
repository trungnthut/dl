<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.modelitem');

class DocumentLibraryModelSubjects extends JModelItem {
    private $fixedData;
    private $lastFixedId;
    private $displayData;
    
    function __construct($config = array()) {
        parent::__construct($config);
		// $this->fixedData = null;
		$this->displayData = null;
        // $this->fixedData = array(
          // 1 => 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_ICT',
          // 2 => 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_MATH',
        // );
//         
        // $this->lastFixedId = count($this->fixedData);
//         
        // $this->displayData = array();
        // foreach ($this->fixedData as $id => $strid) {
            // $this->displayData[$id] = $this->getSubjectName($id);
        // }
    }
    
    function getSubjectName($id) {
    	if (is_array($this->displayData) && in_array($id, $this->displayData)) {
    		return $this->displayData[$id];
    	}
		
    	if ($id <= 0) {
    		return JText::_('COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_INVALID');
    	}

		$db = JFactory::getDbo();
		$query = 'SELECT name FROM #__document_subjects WHERE subject_id = ' . $id;
		$db->setQuery($query);
		$name = $db->loadResult();
        return JText::_($name);
    }
    
    function getSubjectList() {
    	if (is_array($this->displayData) && count($this->displayData) > 0) {
    		return $this->displayData;
    	}
		
        $db = JFactory::getDbo();
		$query = 'SELECT * FROM #__document_subjects WHERE published = 1 ORDER BY subject_order ASC, subject_id ASC';
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		$this->displayData = array();
		foreach ($result as $row) {
			$this->displayData[$row->subject_id] = JText::_($row->name);
		}
		
		return $this->displayData;
    }
}
?>
