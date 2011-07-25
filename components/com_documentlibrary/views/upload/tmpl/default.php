<?php

defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.html.html');

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
echo $this->errorMessage;
?>
<form method="post" enctype="multipart/form-data">
    <fieldset class='userdata'>
        <p style='display: block'>
            <label style='display:block; width: 7.2em; float: left'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_TITLE'); ?>:</label>
            <input type="text" name="documentTitle" class='inputbox' size="75.7em" value="<?php echo $this->parentDocument->title?>"/>
        </p>

        <p style='display: block; clear: left'>
            <label style='display:block; width: 7.2em; float: left'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_TYPE');?>:</label>
            <?php
                $typeHtmlOptions = array(
                    'name' => 'documentType',
//                    'css' => 'class="inputbox" style="float: left;"'
                    'default' => $this->parentDocument ? $this->parentDocument->type_id : 1
                );
                
                echo selectionBox($this->documentTypes, $typeHtmlOptions);
            ?>
        </p>

        <p style='display: block; clear: left'>
            <label style='display: block; width: 7.2em; float: left;'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUBJECT'); ?>:</label>
            <?php
                $subjectHtmlOptions = array(
                    'name' => 'subject',
                    'css' => 'class="inputbox" style="float: left"',
                    'default' => $this->parentDocument ? $this->parentDocument->subject_id : 1
                );
                
                echo selectionBox($this->subjectList, $subjectHtmlOptions);
            ?>
            
            <label style='display: block; width: 4.2em; float: left; margin-left: 1em'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_LESSON'); ?>:</label>
            <input type='text' name='lesson' style='float: left; width: 4.9em' value='<?php echo $this->parentDocument->lesson; ?>'/>
            <label style='display: block; width: 4.2em; float: left; margin-left: 1em'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_CLASS'); ?>:</label>
            <?php
                $classHtmlOptions = array(
                    'name' => 'class',
                    'default' => $this->parentDocument ? $this->parentDocument->class_id : 1
                );
                echo selectionBox($this->classList, $classHtmlOptions); 
            ?>
        </p>

        <p>
            <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_SUMMARY');?>:</label>
            <br/>
            <textarea cols='70' rows='7' name='summary' ><?php echo $this->parentDocument->summary; ?></textarea>
            <br/>
        </p>

        <p>
            <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_QUESTION');?>:</label>
            <br/>
            <textarea cols='70' rows='2' name='question' ><?php echo $this->parentDocument->question; ?></textarea>
            <br/>
        </p>

        <p>
            <label style='display: block; width: 7.2em; float: left;'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_FILE');?>:</label>
            <input type='file' name='documentFile' class='input'/>
        </p>
        
        <input type='hidden' name='original' value='<?php echo $this->parentDocument->original_id; ?>' />
        <input type='hidden' name='parent' value='<?php echo $this->parent_id; ?>' />

        <input type='submit' name='submit' class='button' value='<?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_UPLOAD'); ?>'/>
    </fieldset>
</form>