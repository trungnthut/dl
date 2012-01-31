<?php

defined('_JEXEC') or die();
jimport('joomla.application.component.controller');
require('lib/KunenaCategories.php');
require('lib/KunenaMessage.php');
require_once 'lib/XMLNode.php';

class ForumExporterController extends JController {
    function display($cachable = false) {
        JRequest::setVar('view', 'export');
        if (JRequest::getVar('export', '') == 'Export') {
            $forumNode = $this->doExport();
            JRequest::setVar('forumNode', $forumNode);
        }
        parent::display($cachable);
    }
    
    function doExport() {
        $post_categories = JRequest::getVar('categories');
        $all_categories = KunenaCategory::queryCategories();
        $selected_categories = $post_categories;
        $categoriesToSelect = JRequest::getVar('categoriesToSelect', "");
        $categoriesToSelect = explode(',', $categoriesToSelect);
        $ignoreCategories = array_diff($categoriesToSelect, $post_categories);
        foreach ($post_categories as $cat_id) {
            $cat = KunenaCategory::getCategory($cat_id);
            $this->getSubCategories($cat, $selected_categories, $ignoreCategories);
        }
        $selected_categories = array_unique($selected_categories);
        $mess = KunenaMessage::queryMessages($selected_categories);
        $forumNode = new XMLNode('forum');
        foreach ($mess as $msg) {
            $forumNode->addChild($msg->toXMLNode());
        }
//        var_dump($forumNode->represent());
        return $forumNode;
    }
    
    private function getSubCategories($category, &$arr, $ignoreCategories = array()) {
        foreach ($category->children() as $child) {
            if (!in_array($child->id(), $ignoreCategories)) {
                $arr[] = $child->id();
                $this->getSubCategories($child, $arr);
            }
        }
    }
}

?>
