<?php

defined('_JEXEC') or die();

// import Joomla view library
jimport('joomla.application.component.view');

class DocumentLibraryViewUserStats extends JView {

    function display($tpl = null) {
        // Get data from the model
        $items = $this->get('Items');
        $pagination = $this->get('Pagination');

        // Check for errors.
        if (count($errors = $this->get('Errors'))) {
            JError::raiseError(500, implode('<br />', $errors));
            return false;
        }

        // get user profile
        $statisticsModel = $this->getModel("UserStats");
        foreach ($items as $key => $item) {
            $item = $statisticsModel->getUserProfileByUser($item);
        }

//        // Get doc type list
//        $docType = $statisticsModel->getDocumentTypeList();

        // column number
        $numCol = 8;

        // Assign data to the view
        $this->items = $items;
//        $this->docType = $docType;
        $this->numCol = $numCol;
        $this->pagination = $pagination;
//        $this->totalComments = $totalComments;


        // Set the toolbar
        $this->addToolBar();
        parent::display($tpl);
    }

    /**
     * Setting the toolbar
     */
    protected function addToolBar() {
        JToolBarHelper::title(JText::_('Users statistics'));
        JToolBarHelper::back('JTOOLBAR_BACK', JRoute::_('index.php?option=com_documentlibrary'));
    }

}

?>
