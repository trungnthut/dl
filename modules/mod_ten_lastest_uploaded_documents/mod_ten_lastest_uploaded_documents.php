<?php
defined('_JEXEC') or die ('Access denined'); // no direct access allowed
 
require_once dirname(__FILE__).DS.'helper.php'; // get helper files
 
// get 10 lastest uploaded document
$listLastestUploadedDocument = ModTenLastestUploadedDocumentsHelper::getLastestUploadedDocument(10);
require JModuleHelper::getLayoutPath('mod_ten_lastest_uploaded_documents');
?>