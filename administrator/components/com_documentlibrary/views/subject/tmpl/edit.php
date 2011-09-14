<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('behavior.tooltip');
?>
<form action="<?php echo JRoute::_('index.php?option=com_documentlibrary&layout=edit&subject_id='.(int) $this->item->subject_id); ?>"
      method="post" name="adminForm" id="documentlibrarysubject-form">
	<fieldset class="adminform">
		<legend>
		<?php 
			if ($this->isNew) {
				echo JText::_( 'COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_MANAGER_NEW_LABEL' );
			} else {
				echo JText::_( 'COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_MANAGER_EDIT_LABEL' );
			} 
		?>
		</legend>
		<ul class="adminformlist">
			<?php foreach($this->form->getFieldset() as $field): ?>
						<li><?php echo $field->label;echo $field->input;?></li>
			<?php endforeach; ?>
		</ul>
	</fieldset>
	<div>
		<input type="hidden" name="task" value="subject.edit" />
		<?php echo JHtml::_('form.token'); ?>
	</div>
</form>