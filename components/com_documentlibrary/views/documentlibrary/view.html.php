<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

// import joomla view library
jimport('joomla.application.component.view');

/**
 * The view class DocumentLibraryViewDocumentLibrary
 */
class DocumentLibraryViewDocumentLibrary extends JView {
    // must overide display method or we'll get some error message in joomla (because we do not have template yet
    function display($tpl = null) {
    	// set viewAll = 1 so count comments & count downloads will count for all version
    	JRequest::setVar('viewAll', 1);
		$this->viewAll = 1;
        // again, JView has a variable name msg == may be not, because template use a var with that name
        $this->msg = $this->get('msg');
        $this->subjectsclasses = $this->get('SubjectsClasses', 'SubjectsClasses');
        $this->selectedSubjectId = (int)JRequest::getVar('subject', 0);
        $this->selectedClassId = (int)JRequest::getVar('class', 0);
        $this->filter=(int)JRequest::getVar('filter', 0);
        $this->documentTypes = $this->get('DocumentTypes', 'DocumentType');
        $this->documentStatsByType = $this->get('DocumentStatsByType');
        $this->documentStatsBySubject = $this->get('DocumentStatsBySubject');
		$noneFilter = new stdClass();
		{
			$noneFilter->type_id = 0;
			$noneFilter->name = JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LIBRARY_FILTER_NONE');
		}
        $this->documentTypes[0] = $noneFilter;
		
        $this->documents = $this->get('Items');
        $this->pagination = $this->get('Pagination');
        
        $this->classModel = & $this->getModel('Classes');
        $this->subjectModel = & $this->getModel('Subjects');
        $this->documentTypeModel = & $this->getModel('DocumentType');
        $this->documentModel = & $this->getModel('Document');
        
        // Check for errors. ?? no error ??? :o -.=
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // display the template with the variable $this->msg
        parent::display($tpl);
    }
}
?>
