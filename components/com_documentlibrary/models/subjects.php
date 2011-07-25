<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.modelitem');

class DocumentLibraryModelSubjects extends JModelItem {
    private $fixedData;
    private $lastFixedId;
    private $displayData;
    
    function __construct($config = array()) {
        parent::__construct($config);
        $this->fixedData = array(
          1 => 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_ICT',
          2 => 'COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_MATH',
        );
        
        $this->lastFixedId = count($this->fixedData);
        
        $this->displayData = array();
        foreach ($this->fixedData as $id => $strid) {
            $this->displayData[$id] = $this->getSubjectName($id);
        }
    }
    
    function getSubjectName($id) {
        if ($id < 1 && $id > $this->lastFixedId) {
            return JText::_('COM_DOCUMENT_LIBRARY_MODEL_SUBJECTS_INVALID');
        }
        
        return JText::_($this->fixedData[$id]);
    }
    
    function getSubjectList() {
        return $this->displayData;
    }
}
?>
