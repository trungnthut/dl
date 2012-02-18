<?php

defined('_JEXEC') or die;

// import Joomla view library
jimport('joomla.application.component.view');

class DocumentlibraryViewControlPanel extends JView {

    function display($tpl = null) {
        $this->addToolBar();
        parent::display($tpl);
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar() {
        JToolBarHelper::title(JText::_('Document library control panel'));
        JToolBarHelper::back('JTOOLBAR_BACK', JRoute::_('index.php'));
    }

}

?>
