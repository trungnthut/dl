<?php
class ModTenMostDownloadedDocumentsHelper
	{
	/**
     * TODO: get list most downloaded document
     * @param $num number of most downloaded document ($num = 10)
     * @return type 
     */
    function getMostDownloadedDocument($num) {
		$query = 'SELECT D . * , count(DD.document_id) AS total_download'
				.' FROM #__documents D, #__document_downloads DD'
				.' WHERE D.document_id = DD.document_id'
				.' GROUP BY DD.document_id'
				.' ORDER BY total_download DESC, D.document_id DESC'
				.' LIMIT 0,'. $num;
		//echo $query;
		$db = JFactory::getDbo();
        $db->setQuery($query);
		return $db->loadObjectList();
    }
}
?>