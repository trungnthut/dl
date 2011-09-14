<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
?>
<?php foreach ($this->items as $i => $item) :?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo JHtml::_('grid.id', $i, $item->subject_id); ?>
		</td>
		<td>
			<?php echo $item->subject_id; ?>
		</td>
		<td>
			<a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&task=subject.edit&subject_id='.(int) $item->subject_id); ?>">
			<?php echo $this->escape($item->name); ?></a>
		</td>
		<td align="center">
			<?php //echo $item->published; ?>
			<?php echo JHtml::_('jgrid.published', $item->published, $i, 'subjects.', true, 'cb', '', ''); ?>
		</td>
		<td align="center">
			<?php echo $item->subject_order; ?>
		</td>
	</tr>
<?php endforeach; ?>