<?php
defined ('_JEXEC') or die ('Access denied.');

jimport ('joomla.application.component.view');

class DocumentLibraryViewDocument extends JView {
    
    private function uiText($text) {
        return JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_' . $text);
    }
    
    function display($tpl = null) {
    	//disable view all
    	JRequest::setVar('viewAll', 0);
        $this->documentInfo = $this->get('DocumentInfo');
        $this->documentVersion = $this->documentInfo->version;
        $this->documentTitle = $this->documentInfo->title;
        $this->documentSummary = $this->documentInfo->summary;
        $this->documentQuestion = $this->documentInfo->question;
		$this->documentUploaderId = $this->documentInfo->uploader_id;
        $this->documentUploader = $this->documentInfo->name;
        $this->documentDate = $this->documentInfo->date;
        $this->documentDownloadedTimes = $this->documentInfo->no_downloads;
        $this->documentNoComments = $this->get('NoComments');
        $this->documentNoVersions = $this->get('NoVersions');
        $this->documentOriginalId = $this->documentInfo->original_id;
        $this->documentId = $this->documentInfo->document_id;
        if ($this->documentOriginalId == 0) {
            $this->documentOriginalId = $this->documentId;
        }
        $this->documentNumber = $this->documentOriginalId;
        
//        $this->comments = $this->get('Comments', 'DocumentComments');
        $this->comments = $this->get('Items', 'DocumentComments');
        $this->pagination = $this->get('Pagination', 'DocumentComments');
        
        // breadcrumbs
        $mainFrame = & JFactory::getApplication();
        $pathway = & $mainFrame->getPathway();
        $pathway->addItem($this->uiText('LIBRARY'), JRoute::_('index.php?com=documentLibrary&task=documentLibrary'));
        
        $class_id = $this->documentInfo->class_id;
        $classModel = $this->getModel('Classes');
        $class = $classModel->getClassName($class_id);
        $pathway->addItem($class);
        
        $subject_id = $this->documentInfo->subject_id;
        $subjectModel = $this->getModel('Subjects');
        $subject = $subjectModel->getSubjectName($subject_id);
        $pathway->addItem($subject);
        // finish breadcrumbs
        
        parent::display($tpl);
    }
}
?>
