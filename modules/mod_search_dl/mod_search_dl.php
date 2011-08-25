<?php
defined('_JEXEC') or die; // no direct access allowed
 
require_once dirname(__FILE__).DS.'helper.php'; // get helper files

// get URL for search
$searchURL = JRoute::_('index.php?option=com_documentlibrary&view=search');
$advancedSearchURL = JRoute::_('index.php?option=com_documentlibrary&view=search&advance_box_display=1');
$openByNumberURL = JRoute::_('index.php?option=com_documentlibrary&view=documentlibrary&task=openDocumentByNumber');
require JModuleHelper::getLayoutPath('mod_search_dl');
?>