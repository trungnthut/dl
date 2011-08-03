<?php
defined ('_JEXEC') or die ('Access denied.');

jimport ('joomla.application.component.modellist');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

class DocumentLibraryModelDocumentComments extends JModelList {
    function insertComment($data) {
        $db = JFactory::getDbo();
        $db->insertObject('#__document_comments', $data, 'comment_id');
        $id = $db->insertid();
        return $id;
    }
    
    protected function getListQuery($id = 0) {
        if ($id <= 0) {
            $id = JRequest::getVar('document', 0);
        }
        if ($id <= 0) {
            return "";
        }
		
		$ids = array($id);
		$viewAll = DocumentLibraryHelper::viewAllValue();
		if ($viewAll) {
			include_once 'document.php';
			$documentModel = new DocumentLibraryModelDocument();
			$ids = $documentModel->versionList($id);
		}
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DC.*, U.name, D.version, D.original_id');
        $query->from('#__document_comments DC, #__users U, #__documents D');
        $query->where('DC.document_id IN ('. implode(',', $ids) . ')');
        $query->where('DC.poster_id = U.id');
		$query->where('DC.document_id = D.document_id');

        return $query;
    }
	
    function getComments($id = 0) {
        $query = $this->getListQuery($id);
        if (empty ($query)) {
            return array();
        }
        $db = JFactory::getDbo();
        $db->setQuery($query);
        return $db->loadObjectList();
    }
}

?>
