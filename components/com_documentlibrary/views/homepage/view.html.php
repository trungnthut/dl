<?php

defined ('_JEXEC') or die ('Access denined');

jimport('joomla.application.component.view');

class DocumentLibraryViewHomePage extends JView {
    function display($tpl = null) {
        echo "This's the homepage";
        
        parent::display($tpl);
    }
}

?>
