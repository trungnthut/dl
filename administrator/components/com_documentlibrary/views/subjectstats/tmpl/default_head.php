<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<tr>
    <th>
        <?php echo JText::_('Idx'); ?>
    </th>
	<th>
		<?php echo JText::_('Subject'); ?>
	</th>
	<?php foreach ($this->docType as $key => $item) :?>
	<th>
		<?php echo JText::_($item["docTypeName"]);?>
	</th>
	<?php endforeach; ?>
</tr>