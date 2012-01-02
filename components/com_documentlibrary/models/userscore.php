<?php

defined ('_JEXEC') or die();

jimport ('joomla.application.component.modellist');

class DocumentLibraryModelUserScore extends JModelList {
	function updateUserScore($user_id, $score) {
		if ($user_id <= 0 || $score == 0) {
			// nothing to do
			return;
		}
		$db = JFactory::getDbo();
		$query = 'UPDATE #__dl_score SET score = score + ' . $score . 'WHERE user_id = ' . $user_id;
		$db->setQuery($query);
		$db->query();
		return $db->getAffectedRows() > 0;
	}
	
	function getUserScore($user_id) {
		if ($user_id <= 0) {
			return 0;
		}
		
		$query = 'SELECT score FROM #__dl_score WHERE user_id = ' . $user_id;
		$db = JFactory::getDbo();
		$db->setQuery($query);
		return $db->loadResult();
	}
}
?>