<?php
defined ('_JEXEC') or die();

class ModAupHighScoreHelper {
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
    
    function queryScore($max = 10) {
        if ($max <= 0) {
            $max = 10;
        }
        $exceptUsers = $this->queryAdminUsers();
        $db = JFactory::getDbo();
        $query = 'SELECT userid, referreid, points FROM #__alpha_userpoints WHERE '
                .' userid NOT IN (' . implode(',', $exceptUsers) . ')' // disable admin
                .' AND userid > 0' // disable GUEST
                .' ORDER BY points DESC LIMIT ' . $max
                .'';
        $db->setQuery($query);
        $res = $db->loadObjectList();
        return $res;
    }
}
?>
