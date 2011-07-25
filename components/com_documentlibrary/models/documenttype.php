<?php
// no direct access
defined ('_JEXEC') or die ('Access denied');

jimport('joomla.application.component.modelitem');

class DocumentLibraryModelDocumentType extends JModelItem {
    private $fixedData;
    private $lastFixedId;
    private $displayData;
    
    private function initFixedData() {
        if (empty ($this->fixedData)) {
            $this->fixedData = array(
                1 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_DOC',
                2 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_VIDEO',
                3 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_IMAGE',
                4 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_AUDIO',
            );
            $this->lastFixedId = count($this->fixedData);
        }
    }
    
    function getTypeName($id) {
        if ($id > $this->lastFixedId || $id < 0) {
            return JText::_("COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_INVALID");
        }
        if (empty($this->fixedData)) {
            $this->initFixedData();
        }
        
        return JText::_($this->fixedData[$id]);
    }
    
    function getDocumentTypes() {
        if (empty($this->fixedData)) {
            $this->initFixedData();
        }
        
        if (empty ($this->displayData)) {
            $this->displayData = array();
            foreach ($this->fixedData as $key => $value) {
                $this->displayData[$key] = $this->getTypeName($key);
            }
        }
        
        return $this->displayData;
    }
}
?>
