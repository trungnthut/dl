<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.modellist');

class DocumentLibraryModelDocumentDownloads extends JModelList {
	protected function getListQuery($id = 0) {
        if ($id <= 0) {
            $id = JRequest::getVar('document', 0);
        }
        if ($id <= 0) {
            return "";
        }
        
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DD.*, U.name');
        $query->from('#__document_downloads DD, #__users U');
        $query->where('DD.document_id = '. $id);
        $query->where('DD.user_id = U.id');

        return $query;
    }
}
?>