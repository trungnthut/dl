<?php
class ModTenMostInterestedDocumentsHelper
	{
	/**
     * TODO: get list most interested document
     * @param $num number of most interested document ($num = 10)
     * @return type 
     */
    function getMostInterestedDocument($num) {
		$query = 'SELECT D . * , count(C.comment_id) AS total_comment, U.name as uploader'
				.' FROM #__documents D, #__document_comments C, #__users U'
				.' WHERE (D.document_id = C.document_id) AND (D.uploader_id = U.id)'
				.' GROUP BY C.document_id'
				.' ORDER BY total_comment DESC'
				.' LIMIT 0,'. $num;
		//echo $query;
		$db = JFactory::getDbo();
        $db->setQuery($query);
		return $db->loadObjectList();
    }
}
?>