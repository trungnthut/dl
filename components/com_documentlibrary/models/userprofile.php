<?php
defined ('_JEXEC') or die;

jimport ('joomla.application.component.modelitem');

class DocumentLibraryModelUserProfile extends JModelItem {
	function getUserInfo($id = 0) {
		if ($id <= 0) {
			$id = JRequest::getInt('user_id', 0);
		}
		if ($id <= 0) {
			$id = null;	
		}
		$user = JFactory::getUser($id);
	}
}
?>