<?php
defined('_JEXEC') or die ('Access denined'); // no direct access allowed
 
require_once dirname(__FILE__).DS.'helper.php'; // get helper files
 
// get 10 lastest uploaded document
$modTenMostDownloadedDocumentsHelper = new ModTenMostDownloadedDocumentsHelper();
$listMostDownloadedDocument = $modTenMostDownloadedDocumentsHelper->getMostDownloadedDocument(10);
require JModuleHelper::getLayoutPath('mod_ten_most_downloaded_documents');
?>