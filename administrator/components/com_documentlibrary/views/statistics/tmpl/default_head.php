<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_USER_ID'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_USERNAME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_NAME'); ?>
	</th>
		<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_REGISTERDATE'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_SUBJECT'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_SEX'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_SCHOOL'); ?>
	</th>
	<?php foreach ($this->docType as $key => $item) :?>
	<th>
		<?php echo JText::_($item["docTypeName"]);?>
	</th>
	<?php endforeach; ?>
</tr>