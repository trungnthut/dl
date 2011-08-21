<?php
defined ('_JEXEC') or die;

jimport ('joomla.application.component.modellist');

class DocumentLibraryModelFilter extends JModelList {
	function getListQuery() {
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		
		$subject_id = JRequest::getInt('subject', 0);
		$class_id = JRequest::getInt('class', 0);
		$type_id = JRequest::getInt('type', 0);
		
		$query->select('D.*, U.name AS user, DATE(D.uploaded_time) AS date');
		$query->from('#__documents D, #__users U');
		$query->where('U.id = D.uploader_id');
		if ($subject_id > 0) {
			$query->where('D.subject_id = ' . $subject_id);
		}
		if ($class_id > 0) {
			$query->where('D.class_id = ' . $class_id);
		}
		if ($type_id > 0) {
			$query->where('D.type_id = ' . $type_id);
		}
		
		return $query;
	}
}
?>
