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
        <th>
            <?php echo JText::_('Profesional'); ?>
        </th>
	</th>
	<?php foreach ($this->subjects as $key => $item) :?>
	<th>
		<?php echo JText::_($item["name"]);?>
	</th>
	<?php endforeach; ?>
</tr>