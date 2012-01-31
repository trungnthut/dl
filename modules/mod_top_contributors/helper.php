<?php
defined ('_JEXEC') or die();

class ModTopContributorHelper {
        private $adminGroups;
    
    function __construct() {
        $this->init();
    }
    
    function init() {
        $this->adminGroups = array(7, 8);
    }
    
    function queryAdminUsers() {
        $db = JFactory::getDbo();
        $query = 'SELECT DISTINCT user_id FROM #__user_usergroup_map WHERE group_id IN (' . implode(',', $this->adminGroups) . ')';
        $db->setQuery($query);
        $res = $db->loadObjectList();
        $ret = array();
        foreach ($res as $obj) {
            $ret[] = $obj->user_id;
        }
        return $ret;
    }
    
    function queryData($max = 10) {
        if ($max <= 0) {
            $max = 10;
        }
        $ignores = $this->queryAdminUsers();
        $db = JFactory::getDbo();
        $query = 'SELECT uploader_id, COUNT(document_id) as noDocs FROM #__documents'
                .' WHERE uploader_id NOT IN (' . implode(',', $ignores) . ')'
                .' GROUP BY uploader_id'
                .' ORDER BY noDocs DESC'
                .' LIMIT ' . $max
                .'';
        $db->setQuery($query);
        $res = $db->loadObjectList();
        return $res;
    }
}
?>
