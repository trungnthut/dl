<?php
defined ('_JEXEC') or die ('Access denied');

jimport('joomla.application.component.view');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_SEARCH_');

class DocumentLibraryViewSearch extends JView {
	function display($tpl = null) {
		$this->postUrl = DocumentLibraryHelper::url('search');
		$this->searchMode = true;
		
		$this->quickKeywordTypes = array(
			1 => DocumentLibraryHelper::uiText('BY_DOCUMENT_TITLE'),
			2 => DocumentLibraryHelper::uiText('BY_DOCUMENT_NUMBER')
		);
		$this->defaultKeywordType = JRequest::getVar('quick_keyword_type', 1);
		$this->defaultQuickKeyword = JRequest::getVar('quick_keyword', '');
		
		$this->advanceBoxDisplay = JRequest::getVar('advance_box_display', 'none');
		
		$classList = $this->get('ClassList', 'Classes');
		$this->classList = array_merge(array('0' => DocumentLibraryHelper::uiText('OPTION_NONE')), $classList);
		$this->defaultClass = JRequest::getVar('class', 0);
		
		$subjectList = $this->get('SubjectList', 'Subjects');
		$this->subjectList = array_merge(array('0' => DocumentLibraryHelper::uiText('OPTION_NONE')), $subjectList);
		$this->defaultSubject = JRequest::getVar('subject', 0);
		
		$this->documentTypes = $this->get('DocumentTypes', 'DocumentType');
		$this->selectedTypes = JRequest::getVar('documentTypes', null);
		
		// when user pressing "Search" button
		$search = JRequest::getVar('search', null);
		if (!empty($search)) {
			JRequest::setVar('listAll', 1);
			$this->documents = $this->get('Items', 'DocumentLibrary');
			
			if (!empty($this->documents)) {
				$this->pagination = $this->get('Pagination', 'DocumentLibrary');
			
				$this->classModel = $this->getModel('Classes');
				$this->subjectModel = $this->getModel('Subjects');
				$this->documentTypeModel = $this->getModel('DocumentType');
				$this->documentModel = $this->getModel('Document');
			} else {
				JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_GENERIC_SEARCH_NO_RESULT'));
			}
		}
		
		parent::display($tpl);
	}
}
?>