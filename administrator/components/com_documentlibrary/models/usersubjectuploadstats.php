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
class DocumentlibraryModelUserSubjectUploadStats extends DocumentlibraryModelBaseStatistics
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
		$query = "SELECT U.id, U.name, U.username, COUNT(D.document_id) AS totalDocs, DS.name as profesional"
                        ." FROM #__users U INNER JOIN #__documents D"
                        ." ON D.uploader_id = U.id"
                        ." LEFT JOIN #__user_profiles UF ON UF.user_id = U.id AND UF.profile_key='profile.subject'"
                        ." LEFT JOIN #__document_subjects DS ON DS.subject_id = UF.profile_value"
                        ." WHERE U.block=0"
                        ." GROUP BY U.id"
                        ." ORDER BY U.id ASC";
		return $query;
	}
        
        function getUserUploadStatsBySubject($user_id) {
		// Load the profile data from the database.
		$db = JFactory::getDbo();
                $query = 'SELECT subject_id, COUNT(document_id) AS totalUploads'
                        .' FROM #__documents'
                        .' WHERE uploader_id = ' . $user_id
                        .' GROUP BY subject_id';
		$db->setQuery($query);
                $res = $db->loadObjectList();
                $uploadInfo = array();
		$totalDocByUser = 0;
                foreach ($res as $userUpload) {
                    $uploadInfo[$userUpload->subject_id] = $userUpload->totalUploads;
                    $totalDocByUser += $userUpload->totalUploads;
                }
                $uploadInfo['total'] = $totalDocByUser;

		return $uploadInfo;
	}
        
        function getSubjectList() {
            $query = 'SELECT subject_id, name FROM #__document_subjects';
            $db = JFactory::getDbo();
            $db->setQuery($query);
            $res = $db->loadObjectList();
            $ret = array();
            foreach ($res as $obj) {
                $ret[$obj->subject_id] = array();
                $ret[$obj->subject_id]['name'] = $obj->name;
                $ret[$obj->subject_id]['total'] = 0;
            }
            $ret['total'] = array('name' => 'Totals', 'total'=> 0);
            return $ret;
        }
}