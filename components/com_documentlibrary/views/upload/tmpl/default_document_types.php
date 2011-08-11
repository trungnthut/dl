<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_');

$checked = 'checked';
?>
<?php if ($this->parent_id <= 0) { ?>
<!--         <p style='display: block; clear: left'> -->
            <fieldset>
            	<legend>
            		<label style='display:block; width: 10.9em; float: left'><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_LABEL_TYPE');?>:</label><br/>
            	</legend>
            	<dl style='margin-left: 1.5em'>
            <?php foreach ($this->documentTypes as $id => $type ) { ?>
<!-- 				<p> -->
	<dt>
				<?php
					$js = '';
					// $subtype_id = 'documentSubtypes' . $type->type_id;
					$subtype_name = 'documentSubtypes[' . $type->type_id .']';
					// if ($type->extends) {
						// $js="onPropertyChange='document.getElementById(\"${subtype_id}\").disabled=!this.checked;'";
					// }
				?>
					<input type='radio' id='documentType<?php echo $type->type_id; ?>' name='documentType' value='<?php echo $type->type_id; ?>' <?php echo $checked; ?>><?php echo $type->name; ?></input>
					<?php
						$checked = ''; 
					?>
					</dt>
					<dd>
					<?php 
						$optionsArr = array();
						if ($type->extends) {
							foreach ($type->children as $child) {
								$optionsArr[$child->type_id] = $child->name;
							}
							$box = DocumentLibraryHelper::selectionBox($optionsArr, array('name' => $subtype_name));
							echo $box;
						} 
					?>
					</dd>
<!-- 					<br/> -->
				<!-- </p> -->
            <?php } ?>
            </dl>
            </fieldset>
<!--        </p> -->
<?php } else { ?>
	<label style='display: block; width: 10.9em; float: left;'><?php echo DocumentLibraryHelper::uiText('LABEL_TYPE'); ?>:</label>
	<label><?php echo $this->documentTypeModel->getTypeName($this->parentDocument->type_id); ?></label>
<?php } ?>
