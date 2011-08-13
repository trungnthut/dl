<?php
defined ('_JEXEC') or die;

jimport ('joomla.application.component.view');

class DocumentLibraryViewUserDownloads extends JView {
	function display($tpl = null) {
		$user_id = JRequest::getVar('user_id', 0);
		
		if ($user_id <= 0) {
			$user_id = null;
			$userInfo = JFactory::getUser();
			$user_id = $userInfo->id;
		} else {
			$userInfo = JFactory::getUser($user_id);
		}
		
		if ($user_id <= 0) {
			JError::raiseWarning(150, DocumentLibraryHelper::uiText('invalid_request', 'generic'));
			parent::display($tpl);
			return;
		}
		
		$this->userName = $userInfo->name;
		
		JRequest::setVar('user_id', $user_id);
		
		$this->userDownloads = $this->get('Items');
		
		$ids = array();
		foreach ($this->userDownloads as $document) {
			$ids[] = $document->document_id;
		}
		
		$ids = array_unique($ids);
		JRequest::setVar('documents', $ids);
		$this->documents = $this->get('documentsInfo');
		
		$this->documentModel = $this->getModel('Document');
		// $this->documentTypeModel = $this->getModel('DocumentType');
		
		parent::display($tpl);
	}	
}
?>