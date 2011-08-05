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
		$search = JRequest::getVar('search', null);
        if ($subject_id > 0 || !empty($search)) {
            $class_id = JRequest::getVar('class', 0);
        }
        $filter_id = JRequest::getVar('filter', 0);
        
		$search_where = array();
		{
			// if we are searching document. Then, class & subject is only valid if advance search box is opened.		
			if (!empty($search)) {
				$advanceBoxDisplay = JRequest::getVar('advance_box_display', 'none');
				$documentTypes = JRequest::getVar('documentTypes', null);
				if ($advanceBoxDisplay ==  'none') {
					$subject_id = 0;
					$class_id = 0;
					$documentTypes = null;
				}
				
				if (!empty($documentTypes)) {
					$documentTypesStr = implode(',', $documentTypes);
					$search_where[] = 'D.type_id IN (' . $documentTypesStr . ')';
				}
				
				$quick_keyword = JRequest::getVar('quick_keyword', null);
				if (!empty($quick_keyword)) {
					$search_where[] = 'D.title LIKE "%' . $quick_keyword . '%"';
				}
			}
		}
		
		// for search function
		$listAll = JRequest::getVar('listAll');
		
        $where = array(
            'D.uploader_id = U.id'
        );
		if (!$listAll) {
			$where[] = 'D.original_id = 0'; // only fetch document that's not the update version of other
		}
        if ($subject_id > 0) {
            $where[] = 'D.subject_id = ' . $subject_id;
        }
        if ($class_id > 0) {
            $where[] = 'D.class_id = ' . $class_id;
        }
        if ($filter_id > 0) {
            $where[] = 'D.type_id = ' . $filter_id;
        }
		if (!empty($search_where)) {
			$where = array_merge($where, $search_where);
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
	/**
     * TODO: get list lastest upload document
     * @param $num number of lastest upload document ($num = 10)
     * @return type 
     */
    function getLastestUploadedDocument($num) {
		$query = 'SELECT D.*, DATE(D.uploaded_time) AS uploaded_date, U.name as uploader' 
                .' FROM #__documents D, #__users U'
				.' WHERE (D.uploader_id = U.id)'
                .' ORDER BY D.uploaded_time DESC'
				.' LIMIT 0,' . $num;
		//echo $query;
		$db = JFactory::getDbo();
        $db->setQuery($query);
		return $db->loadObjectList();
    }
	/**
     * TODO: get list most interested document
     * @param $num number of most interested document ($num = 10)
     * @return type 
     */
    function getMostInterestedDocument($num) {
		$query = 'SELECT D . * , count(C.comment_id) AS total_comment, U.name as uploader'
				.' FROM #__documents D, #__document_comments C, #__users U'
				.' WHERE (D.document_id = C.document_id) AND (D.uploader_id = U.id)'
				.' GROUP BY C.document_id'
				.' ORDER BY total_comment DESC'
				.' LIMIT 0,'. $num;
		//echo $query;
		$db = JFactory::getDbo();
        $db->setQuery($query);
		return $db->loadObjectList();
    }
	/**
     * TODO: get total uploaded document
     * @param 
     * @return type 
     */
    function countDocument() {
		$query = 'SELECT count(D.document_id) AS total_document'
				.' FROM #__documents D';
		//echo $query;
		$db = JFactory::getDbo();
        $db->setQuery($query);
		return $db->loadObject();
    }
}
?>
