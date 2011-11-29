<?php

defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.html.html');
jimport ('joomla.form.form');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

JHTML::_('behavior.formvalidation');

// function selectionBox($optionsArr, $fieldOptions) {
    // $options = array();
    // $selectBox = '';
    // $name = isset ($fieldOptions['name']) ? $fieldOptions['name'] : 'name' ;
    // $css = isset($fieldOptions['css']) ? $fieldOptions['css'] : 'class="inputbox"';
    // $default = isset($fieldOptions['default']) ? $fieldOptions['default'] : 1;
//     
    // foreach ($optionsArr as $key => $value) {
        // $options[] = JHtml::_('select.option', $key, $value);
    // }
//     
    // $selectBox = JHtml::_('select.genericlist', $options, $name, $css, 'value', 'text', $default);
//     
    // return $selectBox;
// }

// function uiText($text) {
	// if (empty($text)) {
		// return '';
	// }
// 	
	// return JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_' . $text);
// }

$disable = $this->parent_id > 0 ? 'disabled' : ''; 

$filterLink = DocumentLibraryHelper::url('filter');

//Start form building
$form = & JForm::getInstance('uploadForm', JPATH_COMPONENT.DS.'models'.DS.'forms'.DS.'upload.xml', array('array' => false));
$fieldset = $form->getFieldSets();

if ($this->parent_id > 0){
	// Prepare form
	// $disabled = $this->parent_id > 0;
	// if (isset($this->parentDocument)) {
		$form->setValue('documentTitle', '', $this->parentDocument->title);
		$form->setFieldAttribute('documentTitle', 'disabled', 'true');
		
		$form->setFieldAttribute('documentType', 'parent_type', $this->parentDocument->type_id);
		
		$form->setValue('subject', '', $this->parentDocument->subject_id);
		$form->setFieldAttribute('subject', 'disabled', 'true');
		
		$form->setValue('lesson', '', $this->parentDocument->lesson);
		$form->setFieldAttribute('lesson', 'disabled', 'true');
		
		$form->setValue('class', '', $this->parentDocument->class_id);
		$form->setFieldAttribute('class', 'disabled', 'true');
		
		$form->setValue('summary', '', $this->parentDocument->summary);
		
		$form->setValue('question', '', $this->parentDocument->question);
	// }
}
$oldSubmit = JRequest::getVar('submit');
if (!empty($oldSubmit)){
	// prepare form, now set value which was input before
	$form->setValue('documentTitle', '', JRequest::getString('documentTitle'));
	$form->setValue('documentType', '', JRequest::getVar('documentType'));
	// $form->setFieldAttribute('documentType', 'subtypes', JRequest::getVar('documentSubtypes'));
	// we need the subtype value also
	$form->setValue('subject', '', JRequest::getVar('subject'));
	$form->setValue('lesson', '', JRequest::getVar('lesson'));
	$form->setValue('class', '', JRequest::getVar('class'));
	$form->setValue('summary', '', JRequest::getVar('summary'));
	$form->setValue('question', '', JRequest::getVar('question'));
}

?>
<p>
       <a href='<?php echo $filterLink; ?>'><?php echo DocumentLibraryHelper::uiText('UPLOAD_NEW_VERSION', 'VIEW', 'UPLOAD');?></a>
</p>

<form name="uploadForm" method="post" enctype="multipart/form-data" onsubmit="return document.formvalidator.isValid(this);" class="form-validate">
<!-- 	<form method="post" enctype="multipart/form-data" class="form-validate"> -->
	
	<fieldset>
		<legend><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPLOAD_TITLE'); ?></legend>
		<?php foreach ($form->getFieldSet('upload') as $field) { ?>
			<?php if ($field->hidden) {
				echo $field->input;
			} else { ?>
				<dl>
					<dt><?php echo $field->label; ?></dt>
					<dd><?php echo $field->input; ?></dd>
				</dl>
			<?php } ?>
			<?php if ($field->name == 'documentTitle' && $this->parent_id > 0 && $this->parentDocument) { ?>
				<dl>
					<dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPDATE_FROM') ?></dt>	
					<dd><?php echo $this->parentDocument->version; ?></dd>
				</dl>
			<?php } ?>
		<?php } ?>
	</fieldset>
<!--     <fieldset> -->
<!--       <legend><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPLOAD_TITLE'); ?></legend>-->
<!--       <dl> -->
<!--         <p style='display: block'> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_TITLE'); ?>:</dt> -->
<!--            <dd><input type="text" name="documentTitle" class='inputbox' style='width: 70%' value="<?php echo isset($this->parentDocument) ? $this->parentDocument->title : '';?>" <?php echo $disable;?>/></dd> -->
<!--         </p> -->

<!--		<?php //if ($this->parent_id > 0 && $this->parentDocument) { ?> -->
<!-- 		<p style='display: block; clear: left'> -->
<!--			<dt><?php //echo uiText('LABEL_UPDATE_FROM'); ?>:</dt> -->
<!--			<dd><?php //echo $this->parentDocument->version; ?></dd> -->
<!-- 		</p> -->
<!--		<?php //} ?> -->

<!-- 		<p style='display: block; clear: left'> -->
<!-- 			<?php //echo $this->loadTemplate('document_types'); ?> -->
<!-- 		</p> -->

<!--         <p style='display: block; clear: left'> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUBJECT'); ?>:</dt> -->
<!--            <dd><?php /*               $subjectHtmlOptions = array(
                    'name' => 'subject',
                    'css' => 'class="inputbox"',
                    'default' => isset($this->parentDocument) ? $this->parentDocument->subject_id : 1,
                    'disabled' => $disable
                );
                
                echo DocumentLibraryHelper::selectionBox($this->subjectList, $subjectHtmlOptions); */
            ?></dd> -->
            
<!--             <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_LESSON'); ?>:</dt> -->
<!--             <dd><input type='text' name='lesson' value='<?php //echo isset($this->parentDocument) ? $this->parentDocument->lesson : ''; ?>' <?php //echo $disable; ?>/></dd> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_CLASS'); ?>:</dt> -->
<!--            <dd>
            <?php
                /*$classHtmlOptions = array(
                    'name' => 'class',
                    'default' => isset($this->parentDocument) ? $this->parentDocument->class_id : 1,
                    'disabled' => $disable
                );
                echo DocumentLibraryHelper::selectionBox($this->classList, $classHtmlOptions); */
            ?>
        </dd> -->
        
        <?php if ($this->parent_id > 0) { ?>
        	<input type='hidden' name='documentTitle' value='<?php echo $this->parentDocument->title; ?>'/>
        	<input type='hidden' name='documentType' value='<?php echo $this->parentDocument->type_id; ?>'/>
        	<input type='hidden' name='subject' value='<?php echo $this->parentDocument->subject_id; ?>'/>
        	<input type='hidden' name='lesson' value='<?php echo $this->parentDocument->lesson; ?>' />
        	<input type='hidden' name='class' value='<?php echo $this->parentDocument->class_id; ?>'/> 
        <?php } ?>

<!--         <p> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUMMARY');?>:</dt> -->
<!--             <br/> -->
<!--            <dd><textarea name='summary' style='width: 99%; height: 9em; border: 1px solid #CCCCCC; margin-left: 2px' ><?php echo isset($this->parentDocument) ? $this->parentDocument->summary : ''; ?></textarea></dd> -->
<!--             <br/> -->
<!--         </p> -->

<!--         <p> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_QUESTION');?>:</dt> -->
<!--             <br/> -->
<!--            <dd><textarea name='question' style='width: 99%; height: 3em; border: 1px solid #CCCCCC; margin-left: 2px' ><?php echo isset($this->parentDocument) ? $this->parentDocument->question : ''; ?></textarea></dd> -->
<!--             <br/> -->
<!--         </p> -->

<!--         <p> -->
<!--            <dt><?php //echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_FILE');?>:</dt> -->
<!--            <dd><input type='file' name='documentFile' class='input'/></dd> -->
<!--         </p> -->
        </dl>
<!--     </fieldset> -->
           <!-- TODO: check and remove original  field -->
        <input type='hidden' name='original' value='<?php echo isset($this->parentDocument) ? $this->parentDocument->original_id : 0; ?>' />
        <input type='hidden' name='parent' value='<?php echo $this->parent_id; ?>' />

        <input type='submit' name='submit' class='button' value='<?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPLOAD'); ?>'/>
</form>
