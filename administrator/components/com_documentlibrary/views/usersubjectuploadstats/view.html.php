<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * Subjects View
 */
class DocumentlibraryViewUserSubjectUploadStats extends JView
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
		$statisticsModel = $this->getModel("UserSubjectUploadStats");
//		foreach($items as $key => $item) {
//			$item = $statisticsModel->getUserProfileByUser($item);
//		}

		// Get doc type list
		$subjects = $statisticsModel->getSubjectList();

		// Get upload document
		foreach($items as $key => $item) {
			$item->uploadDoc = $statisticsModel->getUserUploadStatsBySubject($item->id);
			//var_dump($item->uploadDoc);
			foreach ($item->uploadDoc as $key=>$value) {
				$subjects[$key]["total"] = $subjects[$key]["total"] + $value;
			}
		}
		
		// column number
		$numCol = 4 + count($subjects);
		 
		// Assign data to the view
		$this->items = $items;
		$this->subjects = $subjects;
		$this->numCol = $numCol;
		$this->pagination = $pagination;
		
		 
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
		JToolBarHelper::title(JText::_('User upload statistics by subjects'));
                JToolBarHelper::back('JTOOLBAR_BACK', JRoute::_('index.php?option=com_documentlibrary'));
	}
}