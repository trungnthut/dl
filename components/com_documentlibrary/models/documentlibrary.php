<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

jimport ('joomla.application.component.modellist');

/**
 * DocumentLibraryModelDocumentLibrary
 */
class DocumentLibraryModelDocumentLibrary extends JModelList {
    var $msg;
    
    protected function getListQuery() {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        
        // select from fields
        $query->select('D.*, DATE(D.uploaded_time) AS date, U.name AS user, COUNT(DD.download_id) AS no_downloads');
        // from tablet documents
        $query->from('#__users U, #__documents D');
        
        $query->leftJoin('#__document_downloads DD on D.document_id = DD.document_id');
        
        $subject_id = JRequest::getVar('subject', 0);
        $class_id = 0;
        if ($subject_id > 0) {
            $class_id = JRequest::getVar('class', 0);
        }
        $filter_id = JRequest::getVar('filter', 0);
        
        $where = array(
            'D.uploader_id = U.id',
            'D.original_id = 0' // only fetch document that's not the update version of other
        );
        if ($subject_id > 0) {
            $where[] = 'D.subject_id = ' . $subject_id;
        }
        if ($class_id > 0) {
            $where[] = 'D.class_id = ' . $class_id;
        }
        if ($filter_id > 0) {
            $where[] = 'D.type_id = ' . $filter_id;
        }
        
        $query->where($where);
        $query->group('D.document_id');
        
        return $query;
    }
    
    function insertDocument($data = null) {
        if ($data) {
            $db = JFactory::getDbo();
            $db->insertObject('#__documents', $data, 'document_id');
            $document_id = $db->insertid();
            
            return $document_id;
        }
        
        return -1;
    }
}
?>
