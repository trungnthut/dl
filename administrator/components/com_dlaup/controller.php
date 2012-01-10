<?php
defined('_JEXEC') or die();
jimport('joomla.application.component.controller');

define ('USER_REGISTER_POINT', 'sysplgaup_newregistered');
define ('USER_SCORE_UPLOAD_NEW', 'plgaup_documentlibrary_upload_new');
define ('USER_SCORE_UPLOAD_VERSION', 'plgaup_documentlibrary_upload_version');
define ('USER_SCORE_DOWNLOAD', 'plgaup_documentlibrary_download');
define ('USER_SCORE_DOCUMENT_COMMENT', 'plgaup_documentlirary_comment');

class DlAupController extends JController {
	private $documents;
	private $testing;
	
    function display($cachable = false) {
        JRequest::setVar('view', 'sync');
        parent::display($cachable);
    }
	
	function sync() {
		$this->testing = FALSE;
		$this->documents = array();
		$this->syncDocumentTable();
		$this->syncDocumentDownloadsTable();
		$this->syncDocumentCommentsTable();
	}
	
	function testSync() {
		$this->testing = TRUE;
		$this->documents = array();
		$this->syncDocumentTable();
		$this->syncDocumentDownloadsTable();
		$this->syncDocumentCommentsTable();
	}
	
	function syncUsers() {
		$query = "SELECT id FROM #__users";
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$users = $db->loadObjectList();
		foreach ($users as $user) {
			$this->updateScore(USER_REGISTER_POINT, $user->id, "Welcome!");
		}
		
		echo "Done, sync " . count($users) . " users register score";
	}
	
	private function syncDocumentTable() {
		$query = 'SELECT document_id, original_id, uploader_id, version, DATE(uploaded_time) AS date FROM #__documents';
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$res = $db->loadObjectList();
		$new_doc = 0;
		$new_ver = 0;
		foreach ($res as $obj) {
			if ($obj->original_id == 0) {
				// new document
				$obj->number = $obj->document_id . "." . $obj->version;
				$ref_message = '(sync) upload new document '. $obj->number . ' (' . $obj->date . ')';
				$this->updateScore(USER_SCORE_UPLOAD_NEW, $obj->uploader_id, $ref_message);
				$new_doc++;
			} else {
				// new version
				$obj->number = $obj->original_id . "." . $obj->version;
				$ref_message = '(sync) upload new version '. $obj->number . ' (' . $obj->date . ')';
				$this->updateScore(USER_SCORE_UPLOAD_VERSION, $obj->uploader_id, $ref_message);
				$new_ver++;
			}
			$this->documents[(int)$obj->document_id] = $obj;
		}
		echo "So, sync " . ($new_doc + $new_ver) . '/' . count($res) . "documents: " . $new_doc . ' new doc & ' . $new_ver . ' new ver';
		echo "<br/>";
	}
	
	private function syncDocumentDownloadsTable() {
		$this->prepareDownloadDateTable();
		$query = 'SELECT document_id, user_id, downloaded_date FROM #__document_download_date';
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$res = $db->loadObjectList();
		$count = 0;
		$selfDownload = 0;
		$invalid_downloads = 0;
		// var_dump($this->documents);
		foreach ($res as $obj) {
			// var_dump($obj);
			// if (in_array((int)$obj->document_id, $this->documents) || in_array($obj->document_id, $this->documents)) {
			if (!empty ($this->documents[$obj->document_id])) {
				if ($obj->user_id != $this->documents[$obj->document_id]->uploader_id) {
					// ok, good, insert aup data
					// var_dump($this->documents[$obj->document_id]->number);
					$ref_message = '(sync) download document ' . $this->documents[$obj->document_id]->number . ' (' . $obj->downloaded_date . ')';
					$this->updateScore(USER_SCORE_DOWNLOAD, $obj->user_id, $ref_message);
					$count++;
				} else {
					$selfDownload++;
				}
			} else {
				$invalid_downloads++;
			}
		}
		echo "So, sync " . $count . "/" . count($res) . " download(s), having " . $selfDownload . " self download(s) and " . $invalid_downloads . " invalid download data";
		echo "<br/>";
	}

	private function prepareDownloadDateTable() {
		$drop_query = 'DROP TABLE IF EXISTS #__document_download_date;';
		$create_query = 'CREATE TABLE IF NOT EXISTS `#__document_download_date` ('
						. 'user_id INT(11) NOT NULL,'
						. 'document_id INT(11) NOT NULL,'
						. 'downloaded_date DATE NOT NULL' 
						. ')';
		$update_query = 'INSERT INTO #__document_download_date'
						.'(SELECT DISTINCT user_id, document_id, DATE(time) AS downloaded_date' 
						.' FROM #__document_downloads)';
		$db = JFactory::getDbo();
		$db->setQuery($drop_query);
		$db->query();
		$db->setQuery($create_query);
		$db->query();
		$db->setQuery($update_query);
		$db->query();
	}
	
	private function syncDocumentCommentsTable() {
		$query = 'SELECT document_id, poster_id, time FROM #__document_comments';
		$db = JFactory::getDbo();
		$db->setQuery($query);
		$res = $db->loadObjectList();
		$count = 0;
		$selfComments = 0;
		$invalidComments = 0;
		// var_dump($this->documents);
		foreach ($res as $obj) {
			// if (in_array((int)$obj->document_id, $this->documents)) {
			if (!empty($this->documents[$obj->document_id])) {	
				if ($obj->poster_id != $this->documents[$obj->document_id]->uploader_id) {
					// good, sync aup data
					$ref_message = '(sync) comment to document ' . $this->documents[$obj->document_id]->number . ' (' . $obj->time . ')';
					$this->updateScore(USER_SCORE_DOCUMENT_COMMENT, $obj->poster_id, $ref_message);
					
					$count++;
				} else {
					$selfComments++;
				}
			} else {
				echo "<p>";
				var_dump($obj);
				echo "<br/>";
				var_dump($this->documents[(int)$obj->document_id]);
				echo "<br/>";
				var_dump(in_array((int)$obj->document_id, $this->documents));
				var_dump((int)$obj->document_id);
				echo "</p>";
				$invalidComments++;
			}
		}
		echo "So, sync " . $count . "/" . count($res) . " comment(s), having " . $selfComments . " self comment(s) and " . $invalidComments . " invalid comment data";
		echo "<br/>";
	}
	
	private function updateScore($func_name, $user_id, $reference_message = '') {
		if ($user_id <= 0 || $this->testing  == TRUE) {
			return;
		}
		$api_AUP = JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php';
		if ( file_exists($api_AUP))
		{
    		require_once ($api_AUP);
			$refId = AlphaUserPointsHelper::getReferreid($user_id);
			
			$refId = $_SESSION['referrerid'];
    		AlphaUserPointsHelper::newpoints( $func_name, $refId, '', $reference_message);
		}
	}
}
?>