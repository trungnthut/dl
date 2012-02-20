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
		$query = "SELECT U.id, U.name, U.username, COUNT(document_id) AS totalDocs"
                        ." FROM #__users U, #__documents D"
                        ." WHERE U.block=0"
                        ." AND U.id = D.uploader_id"
                        ." AND D.parent_id = 0"
                        ." GROUP BY U.id"
                        ." ORDER BY U.id ASC";
		return $query;
	}
        
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