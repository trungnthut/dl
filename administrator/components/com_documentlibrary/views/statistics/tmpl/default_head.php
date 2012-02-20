<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th>
        <?php echo JText::_('Idx'); ?>
    </th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_USERNAME'); ?>
	</th>
	<th>
		<?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_NAME'); ?>
	</th>
	</th>
	<?php foreach ($this->docType as $key => $item) :?>
	<th>
		<?php echo $key == 'total' ? JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_TOTAL') :JText::_($item["docTypeName"]);?>
	</th>
	<?php endforeach; ?>
</tr>