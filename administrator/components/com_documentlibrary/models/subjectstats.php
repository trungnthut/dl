<?php
defined('_JEXEC') or die();

jimport('joomla.application.component.modellist');

require_once 'basemodel.php';

class DocumentLibraryModelSubjectStats extends DocumentlibraryModelBaseStatistics {
    function getListQuery() {
        $query = 'SELECT subject_id, name FROM #__document_subjects';
        return $query;
    }
    
    function getSubjectUploadInfo($subject_id) {
        $query = 'SELECT COUNT(document_id) AS totalUploads, type_id FROM #__documents'
                .' WHERE subject_id = ' . $subject_id
                .' GROUP BY type_id';
        $db = JFactory::getDbo();
        $db->setQuery($query);
        $res = $db->loadObjectList();
        $ret = array();
        $totalDoc = 0;
        foreach ($res as $docType) {
            $ret[$docType->type_id] = $docType->totalUploads;
            $totalDoc += $docType->totalUploads;
        }
        $ret['total'] = $totalDoc;
        return $ret;
    }
}
?>
