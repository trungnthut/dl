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

/**
 * Item Model for a Contact.
 *
 * @package		Joomla.Administrator
 * @subpackage	com_contact
 * @since		1.6
 */
class DocumentlibraryModelDownloadStats extends DocumentlibraryModelBaseStatistics
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
		$query = "SELECT U.id, U.id AS user_id, U.username, U.name, COUNT(comment_id) AS totalComments"
                        ." FROM #__users U"
                        ." LEFT JOIN #__document_comments DC"
                        ." ON U.id = DC.poster_id"
                        ." WHERE block=0 "
                        ." GROUP BY U.id"
                        ." ORDER BY id ASC";
		return $query;
	}
        
        function getDownloadStaticticsByUser($user) {
            $query = "SELECT D.type_id, COUNT(DD.download_id) AS totalDownloads "
                    .' FROM #__documents D, #__document_downloads DD'
                    .' WHERE DD.user_id = ' . $user
                    .' AND D.document_id = DD.document_id'
                    .' GROUP BY D.type_id';
            $db = JFactory::getDbo();
            $db->setQuery($query);
            $res = $db->loadObjectList();
            $stats = array();
            $total = 0;
            foreach ($res as $downloadInfo) {
                $stats[$downloadInfo->type_id] = $downloadInfo->totalDownloads;
                $total += $downloadInfo->totalDownloads;
            }
            $stats['total'] = $total;
            return $stats;
        }
}