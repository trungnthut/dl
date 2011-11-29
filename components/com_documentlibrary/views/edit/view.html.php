<?php
defined ('_JEXEC') or die ('Access denied.');

jimport ('joomla.application.component.view');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

class DocumentLibraryViewEdit extends JView {
	function display($tpl = null) {
		// $document_id = JRequest::getVar('document', 0);
		// JError::raiseWarning(157,'thanks' );
		// $url = DocumentLibraryHelper::url('document', array('document' => $document_id));
		// echo $url;
		// $this->setRedirect($url);
		$this->editMode = true;
		parent::display($tpl);
	}
}

?>