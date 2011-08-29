<?php
class ModStatisticsDlHelper
{
    /**
 	* TODO: get total user
 	* @return type 
 	*/
	public function getTotalUser() {
		$query = 'SELECT count(*) as total FROM #__users U';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	
	/**
 	* TODO: get total login
 	* @return type 
 	*/
	public function getTotalLogin() {
		$query = 'SELECT count(*) as total FROM #__user_login UL';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	/**
 	* TODO: get total documents
 	* @return type 
 	*/
	public function getTotalDocument() {
		$query = 'SELECT count(*) as total FROM #__documents D';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	/**
 	* TODO: get total user online
 	* @return type 
 	*/
	public function getTotalUserOnline() {
		$query = 'SELECT count(*) as total FROM #__session S WHERE (S.userid != 0) and (S.guest = 0)';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	/**
 	* TODO: get total guest
 	* @return type 
 	*/
	public function getTotalGuest() {
		$query = 'SELECT count(*) as total FROM #__session S WHERE (S.userid = 0) and (S.guest = 1)';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	/**
 	* TODO: get total comments
 	* @return type 
 	*/
	public function getTotalComment() {
		$query = 'SELECT count(*) as total FROM #__document_comments';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
	/**
 	* TODO: get total download
 	* @return type 
 	*/
	public function getTotalDownload() {
		$query = 'SELECT count(*) as total FROM #__document_downloads';
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObject();
	}
}
?>