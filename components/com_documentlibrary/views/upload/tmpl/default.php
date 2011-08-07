<?php

defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.html.html');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function selectionBox($optionsArr, $fieldOptions) {
    $options = array();
    $selectBox = '';
    $name = isset ($fieldOptions['name']) ? $fieldOptions['name'] : 'name' ;
    $css = isset($fieldOptions['css']) ? $fieldOptions['css'] : 'class="inputbox"';
    $default = isset($fieldOptions['default']) ? $fieldOptions['default'] : 1;
    
    foreach ($optionsArr as $key => $value) {
        $options[] = JHtml::_('select.option', $key, $value);
    }
    
    $selectBox = JHtml::_('select.genericlist', $options, $name, $css, 'value', 'text', $default);
    
    return $selectBox;
}

function uiText($text) {
	if (empty($text)) {
		return '';
	}
	
	return JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_' . $text);
}

$disable = $this->parent_id > 0 ? 'disabled' : ''; 
?>
<form method="post" enctype="multipart/form-data">
    <fieldset class='userdata'>
        <p style='display: block'>
            <label style='display:block; width: 10.9em; float: left'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_TITLE'); ?>:</label>
            <input type="text" name="documentTitle" class='inputbox' size="67em" value="<?php echo $this->parentDocument ? $this->parentDocument->title : '';?>" <?php echo $disable;?>/>
        </p>

		<?php if ($this->parent_id > 0 && $this->parentDocument) { ?>
		<p style='display: block; clear: left'>
			<label style='display:block; width: 10.9em; float: left'><?php echo uiText('LABEL_UPDATE_FROM'); ?>:</label>
			<label><?php echo $this->parentDocument->version; ?></label>
		</p>
		<?php } ?>

		<p style='display: block; clear: left'>
			<?php echo $this->loadTemplate('document_types'); ?>
		</p>

        <p style='display: block; clear: left'>
            <label style='display: block; width: 10.9em; float: left;'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUBJECT'); ?>:</label>
            <?php
                $subjectHtmlOptions = array(
                    'name' => 'subject',
                    'css' => 'class="inputbox" style="float: left"',
                    'default' => $this->parentDocument ? $this->parentDocument->subject_id : 1,
                    'disabled' => $disable
                );
                
                echo DocumentLibraryHelper::selectionBox($this->subjectList, $subjectHtmlOptions);
            ?>
            
            <label style='display: block; width: 4.2em; float: left; margin-left: 1em'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_LESSON'); ?>:</label>
            <input type='text' name='lesson' style='float: left; width: 4.9em' value='<?php echo $this->parentDocument ? $this->parentDocument->lesson : ''; ?>' <?php echo $disable; ?>/>
            <label style='display: block; width: 4.2em; float: left; margin-left: 1em'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_CLASS'); ?>:</label>
            <?php
                $classHtmlOptions = array(
                    'name' => 'class',
                    'default' => $this->parentDocument ? $this->parentDocument->class_id : 1,
                    'disabled' => $disable
                );
                echo DocumentLibraryHelper::selectionBox($this->classList, $classHtmlOptions); 
            ?>
        </p>
        
        <?php if ($this->parent_id > 0) { ?>
        	<input type='hidden' name='documentTitle' value='<?php echo $this->parentDocument->title; ?>'/>
        	<input type='hidden' name='documentType' value='<?php echo $this->parentDocument->type_id; ?>'/>
        	<input type='hidden' name='subject' value='<?php echo $this->parentDocument->subject_id; ?>'/>
        	<input type='hidden' name='lesson' value='<?php echo $this->parentDocument->lesson; ?>' />
        	<input type='hidden' name='class' value='<?php echo $this->parentDocument->class_id; ?>'/> 
        <?php } ?>

        <p>
            <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUMMARY');?>:</label>
            <br/>
            <textarea cols='70' rows='7' name='summary' ><?php echo $this->parentDocument ? $this->parentDocument->summary : ''; ?></textarea>
            <br/>
        </p>

        <p>
            <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_QUESTION');?>:</label>
            <br/>
            <textarea cols='70' rows='2' name='question' ><?php echo $this->parentDocument ? $this->parentDocument->question : ''; ?></textarea>
            <br/>
        </p>

        <p>
            <label style='display: block; width: 10.9em; float: left;'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_FILE');?>:</label>
            <input type='file' name='documentFile' class='input'/>
        </p>
        <!-- TODO: check and remove original  field -->
        <input type='hidden' name='original' value='<?php echo $this->parentDocument ? $this->parentDocument->original_id : 0; ?>' />
        <input type='hidden' name='parent' value='<?php echo $this->parent_id; ?>' />

        <input type='submit' name='submit' class='button' value='<?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPLOAD'); ?>'/>
    </fieldset>
</form>