<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
// import Joomla view library
jimport('joomla.application.component.view');
 
/**
 * HelloWorld View
 */
class DocumentlibraryViewSubject extends JView
{
	/**
	 * display method of Subject view
	 * @return void
	 */
	public function display($tpl = null) 
	{
		// get the Data
		$form = $this->get('Form');
		$item = $this->get('Item');
 
		// Check for errors.
		if (count($errors = $this->get('Errors'))) 
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}
		// Assign the Data
		$this->form = $form;
		$this->item = $item;
 
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
		JRequest::setVar('hidemainmenu', true);
		$isNew = ($this->item->subject_id == 0);
		$this->isNew = $isNew;
		JToolBarHelper::title($isNew ? JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_NEW_LABEL')
		                             : JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_EDIT_LABEL'));
		JToolBarHelper::save('subject.save', 'JTOOLBAR_SAVE');
		JToolBarHelper::cancel('subject.cancel', $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE');
	}
}