<?php
defined ('_JEXEC') or die ('Access denied');

jimport('joomla.form.helper');
JFormHelper::loadFieldClass('textarea');

class JFormFieldDocumentTextarea extends JFormFieldTextarea {
	protected $type='documenttextarea';
	
	function getInput() {
		return "<textarea name='" . $this->name
			."' rows='" . $this->element['rows'] 
			."' style='width: 99%; border: 1px solid #CCCCCC; margin-left: 2px' >"
			.$this->value . "</textarea>";
	}
}

?>