<?php
defined ('_JEXEC') or die;

jimport ('joomla.application.component.modellist');

class DocumentLibraryModelUserDownloads extends JModelList {
	function getListQuery() {
		$user_id = JRequest::getVar('user_id');
		
		$query = 'SELECT *, DATE(DD.time) AS date FROM #__document_downloads DD'
				.' WHERE DD.user_id = ' . $user_id;
				
		return $query;
	}
	
	function getDocumentsInfo($ids = null) {
		if (empty($ids)) {
			$ids = JRequest::getVar('documents', null);
		}
		
		if (empty($ids)) {
			return null;
		}
		
		if (!is_array($ids)) {
			$ids = array($ids);
		}
		
		$query = 'SELECT DISTINCT D.*, DT.name AS type FROM #__documents D, #__document_types DT'
				.' WHERE D.type_id = DT.type_id'
				.' AND D.document_id IN (' . implode(',', $ids) . ')';
			
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$result = $db->loadObjectList();
		$ret = array();
		foreach ($result as $row) {
			$ret[$row->document_id] = $row;
		}
		
		return $ret;
	}
}
?>