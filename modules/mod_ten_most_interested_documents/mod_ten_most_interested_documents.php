<?php
defined('_JEXEC') or die; // no direct access allowed
 
require_once dirname(__FILE__).DS.'helper.php'; // get helper files

// get 10 most interested document
$modTenMostInterestedDocumentsHelper = new ModTenMostInterestedDocumentsHelper();
$listMostInterestedDocument = $modTenMostInterestedDocumentsHelper->getMostInterestedDocument(10);
require JModuleHelper::getLayoutPath('mod_ten_most_interested_documents');
?>