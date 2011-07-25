<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.modelitem');

class DocumentLibraryModelClasses extends JModelItem {
    private $fixedData;
    private $lastFixedId;
    private $displayData;
    
    function __construct($config = array()) {
        parent::__construct($config);
        
        $this->fixedData = array(
            1 => 10,
            2 => 11,
            3 => 12
        );
        
        $this->lastFixedId = count($this->fixedData);
        
        foreach ($this->fixedData as $id => $class) {
            $className = JText::_('COM_DOCUMENT_LIBRARY_MODEL_CLASSES_CLASS_PREFIX') . ' ' . $class;
            $this->displayData[$id] = $className;
        }
    }
    
    function getClassName($id) {
        if ($this->fixedData[$id]) {
            return $this->displayData[$id];
        }
        
        return $id;
    }
    
    function getClassList() {
        return $this->displayData;
    }
}
?>
