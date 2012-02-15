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
		$query = "SELECT * FROM #__users WHERE block=0 ORDER BY id ASC";
		return $query;
	}
	
	// Get user profile by userId
//	function getUserProfileByUser($data) {
//		if (is_object($data)) {
//			$userId = isset($data->id) ? $data->id : 0;
//	
//			// Load the profile data from the database.
//			$db = JFactory::getDbo();
//			$query = 'SELECT a.profile_key as profile_key, a.profile_value AS profile_value, b.name AS subject_name' .
//					' FROM #__user_profiles a' .
//					' LEFT JOIN #__document_subjects b ON ( a.profile_key = ' . "'profile.subject'" . ' AND a.profile_value = b.subject_id )' .
//					' WHERE user_id = '.(int) $userId." AND profile_key LIKE 'profile.%'" .
//					' ORDER BY ordering';
//			$db->setQuery($query);
//			$results = $db->loadRowList();
//	
//			// Check for a database error.
//			if ($db->getErrorNum()) {
//                            JError::raiseError($db->getErrorNum(), $db->getErrorMsg());
////				$this->_subject->setError($db->getErrorMsg());
//				return false;
//			}
//	
//			// Merge the profile data.
//			$data->profile = array();
//			$data->profile['sex'] = "";
//			$data->profile['subject'] = "";
//			$data->profile['school'] = "";
//	
//			foreach ($results as $v) {
//				$k = str_replace('profile.', '', $v[0]);
//				$data->profile[$k] = $v[1];
//				if ($k == "subject") {
//					$data->profile[$k] = $v[2];
//				}
//			}
//		}
//		return $data;
//	}

	function getUploadDocumentByUser($user) {
		// Load the profile data from the database.
		$db = JFactory::getDbo();
		// get document
		$query = "SELECT a.type_id, a.name, count( b.document_id )" .
					" FROM #__document_types a" .
					" LEFT JOIN #__documents b ON (( a.type_id = b.type_id ) AND b.uploader_id = " . $user->id . ")" .
					" WHERE ((a.in_used = 1) AND (a.extends = 0)) " .
					" GROUP BY a.type_id" .
					" ORDER BY a.type_id ASC, a.parent_id ASC";
		$db->setQuery($query);
		//var_dump($query . "<br>****");
		$results = $db->loadRowList();
			
		$totalDocByUser = 0;
		foreach ($results as $v) {
			$user->uploadDoc[$v[0]] = isset($v[2]) ? $v[2] : null;
			$totalDocByUser = $totalDocByUser + $user->uploadDoc[$v[0]];
		}
		$item->uploadDoc["total"] = $totalDocByUser;
		// Check for a database error.
		if ($db->getErrorNum()) {
                    JError::raiseError($db->getErrorNum(), $db->getErrorMsg());
//			$this->_subject->setError($db->getErrorMsg());
			return false;
		}

		return $user;
	}
	
	function getDocumentTypeList() {
		// Load the profile data from the database.
		$db = JFactory::getDbo();
		
		// get user upload document in time from $fromDate to $toDate
		$query = "SELECT type_id, name" .
				" FROM #__document_types a" .
				" WHERE ((a.in_used = 1) AND (a.extends = 0)) " .
				" ORDER BY a.type_id ASC, a.parent_id ASC";
		$db->setQuery($query);
		$results = $db->loadRowList();
		
		foreach ($results as $d) {
			$items[$d[0]]["docTypeName"] = $this->getTypeName($d[0]);
			$items[$d[0]]["docTypeTotal"] = 0;
		}
		// Check for a database error.
		if ($db->getErrorNum()) {
                    JError::raiseError($db->getErrorNum(), $db->getErrorMsg());
//			$this->_subject->setError($db->getErrorMsg());
			return false;
		}
		//var_dump($items);
		return $items;
	}
        
//        private function getTypeName($type_id) {
//            if (!isset($this->typeInfo)) {
//                $this->typeInfo = array();
//                $query = 'SELECT type_id, name, parent_id, extends FROM #__document_types';
//                $db = JFactory::getDbo();
//                $db->setQuery($query);
//                $res = $db->loadObjectList();
//                foreach ($res as $type) {
//                    $this->typeInfo[$type->type_id] = $type;
//                }
//            }
//            
//            $typeName = array();
//            while (true) {
//                if (isset ($this->typeInfo[$type_id])) {
//                    $myType = $this->typeInfo[$type_id];
//                    $typeName[] = JText::_($myType->name);
//                    $type_id = $myType->parent_id;
//                } else {
//                    break;
//                }
//            }
//            $typeName = array_reverse($typeName);
//            return implode(':', $typeName);
//        }
}