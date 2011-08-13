<?php
defined('_JEXEC') or die;

jimport ('joomla.application.component.modellist');

class DocumentLibraryModelUserContrib extends JModelList {
	function getListQuery() {
		$user_id = JRequest::getVar('user_id');
		
		$query = 'SELECT *, DATE(uploaded_time) AS date FROM #__documents WHERE uploader_id = ' . $user_id;
		
		return $query;
	}
}
?>