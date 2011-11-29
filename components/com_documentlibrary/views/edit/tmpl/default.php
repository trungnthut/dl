<?php

defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.html.html');
jimport ('joomla.form.form');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

JHTML::_('behavior.formvalidation');

$disable = (isset($this->parent_id) && $this->parent_id > 0) ? 'disabled' : ''; 

$filterLink = DocumentLibraryHelper::url('filter');

//Start form building
$form = & JForm::getInstance('uploadForm', JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.'upload.xml', array('array' => false));
$fieldset = $form->getFieldSets();

if (isset($this->documentInfo)){
	// Prepare form
	// $disabled = $this->parent_id > 0;
	// if (isset($this->parentDocument)) {
		$form->setValue('documentTitle', '', $this->documentInfo->title);
		// $form->setFieldAttribute('documentTitle', 'disabled', 'true');
		
		// $form->setValue('documentType', '', $this->documentInfo->type_id);
		$form->setFieldAttribute('documentType', 'value',  $this->documentInfo->type_id);
		
		$form->setValue('subject', '', $this->documentInfo->subject_id);
		// $form->setFieldAttribute('subject', 'disabled', 'true');
		
		$form->setValue('lesson', '', $this->documentInfo->lesson);
		// $form->setFieldAttribute('lesson', 'disabled', 'true');
		
		$form->setValue('class', '', $this->documentInfo->class_id);
		// $form->setFieldAttribute('class', 'disabled', 'true');
		
		$form->setValue('summary', '', $this->documentInfo->summary);
		
		$form->setValue('question', '', $this->documentInfo->question);
	// }
}
$oldSubmit = JRequest::getVar('submit');
if (!empty($oldSubmit)){
	// prepare form, now set value which was input before
	$form->setValue('documentTitle', '', JRequest::getString('documentTitle'));
	// $form->setValue('documentType', '', JRequest::getVar('documentType'));
	$form->setFieldAttribute('documentType', 'value',  JRequest::getVar('documentType'));
	// $form->setFieldAttribute('documentType', 'subtypes', JRequest::getVar('documentSubtypes'));
	// we need the subtype value also
	$form->setValue('subject', '', JRequest::getVar('subject'));
	$form->setValue('lesson', '', JRequest::getVar('lesson'));
	$form->setValue('class', '', JRequest::getVar('class'));
	$form->setValue('summary', '', JRequest::getVar('summary'));
	$form->setValue('question', '', JRequest::getVar('question'));
}
$form->removeField('documentFile');

?>
<form name="uploadForm" method="post" enctype="multipart/form-data" onsubmit="return document.formvalidator.isValid(this);" class="form-validate">
<!-- 	<form method="post" enctype="multipart/form-data" class="form-validate"> -->
	
	<fieldset>
		<legend><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_EDIT_LABEL_EDIT_TITLE'); ?></legend>
		<?php foreach ($form->getFieldSet('upload') as $field) { ?>
			<?php if ($field->hidden) {
				echo $field->input;
			} else { ?>
				<dl>
					<dt><?php echo $field->label; ?></dt>
					<dd><?php echo $field->input; ?></dd>
				</dl>
			<?php } ?>
			<?php if ($field->name == 'documentTitle' && isset($this->parent_id) && $this->parent_id > 0 && $this->parentDocument) { ?>
				<dl>
					<dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPDATE_FROM') ?></dt>	
					<dd><?php echo $this->parentDocument->version; ?></dd>
				</dl>
			<?php } ?>
		<?php } ?>
	</fieldset>

<!--     </fieldset> -->
           <!-- TODO: check and remove original  field -->
        <input type='hidden' name='original' value='<?php echo isset($this->parentDocument) ? $this->parentDocument->original_id : 0; ?>' />
        <input type='hidden' name='parent' value='<?php echo $this->parent_id; ?>' />

        <input type='submit' name='submit' class='button' value='<?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_EDIT_LABEL_SAVE'); ?>'/>
</form>
