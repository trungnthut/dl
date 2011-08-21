<?php
defined ('_JEXEC') or die;

jimport ('joomla.application.component.view');

class DocumentLibraryViewFilter extends JView {
	function display($tpl = null) {
		$this->subjects = $this->get('SubjectList', 'Subjects');
		$this->subjects[0] = '?';
		ksort($this->subjects);
		$this->defaultSubject = JRequest::getInt('subject', 0);
		
		$this->classes = $this->get('ClassList', 'Classes');
		$this->classes[0] = '?';
		ksort($this->classes);
		$this->defaultClass = JRequest::getInt('class', 0);
		
		$types = $this->get('DocumentTypes', 'documenttype');
		$this->types = array();
		$this->types[0] = '?';
		foreach ($types as $typeInfo) {
			$this->types[$typeInfo->type_id] = $typeInfo->name;
		}
		$this->defaultType = JRequest::getInt('type', 0);
		
		$filter = JRequest::getVar('search', null);
		if ($filter) {
			// pretty much like search function !
			JRequest::setVar('listAll', 1);
			$this->documents = $this->get('Items');

			if (!empty($this->documents)) {
				$this->pagination = $this->get('Pagination');
			
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
