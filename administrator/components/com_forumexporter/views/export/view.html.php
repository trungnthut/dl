<?php
defined ('_JEXEC') or die();

jimport('joomla.application.component.view');

require_once JPATH_COMPONENT_ADMINISTRATOR . DS . 'lib' . DS . 'KunenaCategories.php';

class ForumExporterViewExport extends JView {
    	function display($tpl = null) {
            $this->categories = KunenaCategory::queryCategories();
            if (JRequest::getVar('export', '') == 'Export') {
                $this->forumNode = JRequest::getVar('forumNode');
            }
            parent::display($tpl);
	}
}

?>
