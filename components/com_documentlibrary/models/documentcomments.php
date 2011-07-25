<?php
defined ('_JEXEC') or die ('Access denied.');

jimport ('joomla.application.component.modellist');

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
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DC.*, U.name');
        $query->from('#__document_comments DC, #__users U');
        $query->where('DC.document_id = '. $id);
        $query->where('DC.poster_id = U.id');

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
