<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.view');

class DocumentLibraryViewDocumentDownloads extends JView {
	function display($tpl = null) {
		$this->document_id = JRequest::getVar('document', 0);
		if ($this->document_id <= 0) {
			JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_INVALID'));
			return;
		}
		$this->downloadsMode = true;
		
		$this->documentDownloads = $this->get('Items');
		
		$this->documentInfo = $this->get('DocumentInfo', 'Document');
		$this->documentTitle = $this->documentInfo->title;
		
		$number = $this->documentInfo->original_id;
		if ($number <= 0) {
			$number = $this->documentInfo->document_id;
		}
		$this->documentNumber = $number . '.' . $this->documentInfo->version;
		$this->numDownloads = $this->documentInfo->no_downloads;
		
		if (empty($this->documentDownloads)) {
			JError::raiseNotice(157, JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_NO_DOWNLOADS'));
		}
		
		parent::display($tpl);
	}
}
?>