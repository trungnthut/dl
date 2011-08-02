<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.view');

class DocumentLibraryViewDocumentTree extends JView {
	function display($tpl = null) {
		$this->document = JRequest::getVar('document');
		$this->tree = $this->get('VersionTree', 'Document');
		$this->treeMode = true;
		$this->documentInfo = $this->get('DocumentInfo', 'Document');
		$this->documentTitle = $this->documentInfo->title;
		$number = $this->documentInfo->original_id;
		if ($number <= 0) {
			$number = $this->documentInfo->document_id;
		}
		$this->documentNumber = $number . '.' . $this->documentInfo->version;
		parent::display($tpl);
	}
}
?>