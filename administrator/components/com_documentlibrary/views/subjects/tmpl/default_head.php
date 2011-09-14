<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th width="20">
		<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count($this->items); ?>);" />
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_ID'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_NAME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_INUSED'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUBJECT_ORDER'); ?>
	</th>
</tr>