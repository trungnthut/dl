<?php
/**
 * @version		$Id: contact.php 21148 2011-04-14 17:30:08Z ian $
 * @package		Joomla.Administrator
 * @subpackage	com_contact
 * @copyright	Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access
defined('_JEXEC') or die;

require_once 'basemodel.php';

jimport('joomla.application.component.modellist');
//include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

/**
 * Item Model for a Contact.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_contact
 * @since		1.6
 */
class DocumentlibraryModelStatistics extends DocumentlibraryModelBaseStatistics
{
	/**
	 * Method to build an SQL query to load the list data.
	 *
	 * @return	string	An SQL query
	 */
	protected function getListQuery()
	{
		// Create a new query object.		
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		// Select some fields
		// get user upload document in time from $fromDate to $toDate
		$query = "SELECT U.id, U.name, U.username, DATE(U.registerDate) AS registerDate FROM #__users U WHERE block=0 ORDER BY id ASC";
		return $query;
	}

//	function getUploadDocumentByUser($user) {
//		// Load the profile data from the database.
//		$db = JFactory::getDbo();
//		// get document
//		$query = "SELECT a.type_id, a.name, count( b.document_id )" .
//					" FROM #__document_types a" .
//					" LEFT JOIN #__documents b ON (( a.type_id = b.type_id ) AND b.uploader_id = " . $user->id . ")" .
//					" WHERE ((a.in_used = 1) AND (a.extends = 0)) " .
////                                        " AND b.parent_id = 0" .
//					" GROUP BY a.type_id" .
//					" ORDER BY a.type_id ASC, a.parent_id ASC";
//		$db->setQuery($query);
//		//var_dump($query . "<br>****");
//		$results = $db->loadRowList();
//			
//		$totalDocByUser = 0;
//		foreach ($results as $v) {
//			$user->uploadDoc[$v[0]] = isset($v[2]) ? $v[2] : null;
//			$totalDocByUser = $totalDocByUser + $user->uploadDoc[$v[0]];
//		}
//		$item->uploadDoc["total"] = $totalDocByUser;
//		// Check for a database error.
////		if ($db->getErrorNum()) {
////                    JError::raiseError($db->getErrorNum(), $db->getErrorMsg());
//////			$this->_subject->setError($db->getErrorMsg());
////			return false;
////		}
//
//		return $user;
//	}
        
        function getUploadDocumentByUser($user_id) {
		// Load the profile data from the database.
		$db = JFactory::getDbo();
                $query = 'SELECT type_id, COUNT(document_id) AS totalUploads'
                        .' FROM #__documents'
                        .' WHERE parent_id = 0 '
                        .' AND uploader_id = ' . $user_id
                        .' GROUP BY type_id';
		$db->setQuery($query);
                $res = $db->loadObjectList();
                $uploadInfo = array();
		$totalDocByUser = 0;
                foreach ($res as $userUpload) {
                    $uploadInfo[$userUpload->type_id] = $userUpload->totalUploads;
                    $totalDocByUser += $userUpload->totalUploads;
                }
                $uploadInfo['total'] = $totalDocByUser;

		return $uploadInfo;
	}
}