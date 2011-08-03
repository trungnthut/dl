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
        
		$ids = array($id);
		$viewAll = DocumentLibraryHelper::viewAllValue();
		if ($viewAll) {
			include_once 'document.php';
			$documentModel = new DocumentLibraryModelDocument();
			$ids = $documentModel->versionList($id);
		}
		
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('DD.*, U.name, D.version, D.original_id');
        $query->from('#__document_downloads DD, #__users U, #__documents D');
        $query->where('DD.document_id IN ('. implode(',', $ids) . ')');
        $query->where('DD.user_id = U.id');
		$query->where('DD.document_id = D.document_id');

        return $query;
    }
}
?>