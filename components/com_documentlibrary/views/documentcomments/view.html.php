<?php
defined ('_JEXEC') or die ('Access denied.');

jimport ('joomla.application.component.view');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

class DocumentLibraryViewDocumentComments extends JView {
	function display($tpl = null) {
		$this->document_id = JRequest::getVar('document', 0);
		
		if ($this->document_id <= 0) {
			JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_COMMENTS_INVALID'));
			return;
		}
		
		$this->comments = $this->get('Items');
		$this->commentsMode = true;
		$this->viewAll = DocumentLibraryHelper::viewAllValue();
		
		$this->documentInfo = $this->get('DocumentInfo', 'Document');
		$this->documentTitle = $this->documentInfo->title;
		
		$number = $this->documentInfo->original_id;
		if ($number <= 0) {
			$number = $this->documentInfo->document_id;
		}
		$this->documentNumber = $number . '.' . $this->documentInfo->version;
		$this->numComments = $this->get('NoComments', 'Document');
		
		parent::display($tpl);
	}	
}
?>