<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Subjects View
 */
class DocumentlibraryViewDownloadStats extends JView
{
	/**
	 * HelloWorlds view display method
	 * @return void
	 */
	function display($tpl = null) 
	{
		// Get data from the model
		$items = $this->get('Items');
		$pagination = $this->get('Pagination');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		
		// get user profile
		$statisticsModel = $this->getModel("DownloadStats");
		foreach($items as $key => $item) {
			$item = $statisticsModel->getUserProfileByUser($item);
		}

		// Get doc type list
		$docType = $statisticsModel->getDocumentTypeList();

                $totalComments = 0;
		// Get upload document
		foreach($items as $key => $item) {
//			$item = $statisticsModel->getUploadDocumentByUser($item);
                        $item->downloadStats = $statisticsModel->getDownloadStaticticsByUser($item->user_id);
			//var_dump($item->uploadDoc);
			foreach ($item->downloadStats as $key=>$value) {
				$docType[$key]["docTypeTotal"] = $docType[$key]["docTypeTotal"] + $value;
			}
                        $totalComments += $item->totalComments;
		}
		
		// column number
		$numCol = 7 + count($docType);
		 
		// Assign data to the view
		$this->items = $items;
		$this->docType = $docType;
		$this->numCol = $numCol;
		$this->pagination = $pagination;
                $this->totalComments = $totalComments;
		
		 
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}
 
	/**
	 * Setting the toolbar
	 */
	protected function addToolBar() 
	{
		JToolBarHelper::title(JText::_('Document comments and downloads statistics'));
                JToolBarHelper::back('JTOOLBAR_BACK', JRoute::_('index.php?option=com_documentlibrary'));
	}
}
