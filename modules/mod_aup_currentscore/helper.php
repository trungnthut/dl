<?php

defined('_JEXEC') or die();

class ModAupCurrentScoreHelper {

    function queryScore() {
        $user = JFactory::getUser();
        if (empty($user) || $user->id <= 0) {
            return 0;
        }
        $db = JFactory::getDbo();
        $query = 'SELECT referreid, points FROM #__alpha_userpoints WHERE '
                . ' userid = ' . $user->id;
        $db->setQuery($query);
        $res = $db->loadObject();
        return $res;
    }

}

?>
