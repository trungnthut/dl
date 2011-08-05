<?php

defined ('_JEXEC') or die ('Access denined');

jimport('joomla.application.component.view');

class DocumentLibraryViewHomePage extends JView {
    function display($tpl = null) {
		$upload_url = JRoute::_('index.php?option=com_documentlibrary&task=upload');
		
		$this->uploadUrl = $upload_url;
		
		// get 10 lastest uploaded document
        $documentLibraryModel = $this->getModel('DocumentLibrary');
        $listLastestUploadedDocument = $documentLibraryModel->getLastestUploadedDocument(10);
		$this->listLastestUploadedDocument = $listLastestUploadedDocument;
		// get 10 most interested document
		$listMostInterestedDocument = $documentLibraryModel->getMostInterestedDocument(10);
		$this->listMostInterestedDocument = $listMostInterestedDocument;

		// get current date
		date_default_timezone_set('UTC');
		$currentDate = date("F j, Y, g:i a");
		//echo $currentDate;
		$this->currentDate =  $currentDate;
		
		// get total info
		$totalDocument = $documentLibraryModel->countDocument();
		$this->totalDocument = $totalDocument;
		
        parent::display($tpl);
    }
}

?>