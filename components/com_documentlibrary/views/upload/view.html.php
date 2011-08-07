<?php
defined('_JEXEC') or die ('Access denied');

$user = & JFactory::getUser();

//if ($user->id <= 0) {
//    die('Please login to process');
//}

jimport('joomla.application.component.view');

class DocumentLibraryViewUpload extends JView {
    function display($tpl = null) {
        $this->documentTypes = $this->get('DocumentTypes', 'DocumentType');
		$this->documentTypeModel = $this->getModel('DocumentType');
        $this->subjectList = $this->get('SubjectList', 'Subjects');
        $this->classList = $this->get('ClassList', 'Classes');
        $this->parent_id = JRequest::getVar('parent', 0);
        $this->original_id = JRequest::getVar('original', $this->parent_id);
        if ($this->parent_id > 0) {
            $documentModel = $this->getModel('Document');
            $this->parentDocument = $documentModel->getDocumentInfo($this->parent_id);
        }
        
        parent::display($tpl);
    }
}
?>
