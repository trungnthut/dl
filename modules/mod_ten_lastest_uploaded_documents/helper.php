<?php
class ModTenLastestUploadedDocumentsHelper
{
    /**
 	* TODO: get list lastest upload document
 	* @param $num number of lastest upload document ($num = 10)
 	* @return type 
 	*/
	public function getLastestUploadedDocument($num) {
		$query = 'SELECT D.*, DATE(D.uploaded_time) AS uploaded_date, U.name as uploader' 
            .' FROM #__documents D, #__users U'
			.' WHERE (D.uploader_id = U.id)'
            .' ORDER BY D.uploaded_time DESC'
			.' LIMIT 0,' . $num;
		//echo $query;
		$db = JFactory::getDbo();
    	$db->setQuery($query);
		return $db->loadObjectList();
	}
}
?>
