<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$totalDoc = 0;
?>
<?php foreach ($this->items as $key => $item) :?>
	<tr class="row<?php echo $i % 2; ?>">
		<td>
			<?php echo $this->escape($item->username); ?>
		</td>
		<td>
			<?php echo $this->escape($item->name); ?>
		</td>
		<td>
			<?php echo $this->escape($item->registerDate); ?>
		</td>
		<td align="center">
			<?php echo empty($item->profile['subject']) ? '_' : JText::_($this->escape($item->profile['subject'])); ?>
		</td>
		<td align="center">
			<?php 
				if ($this->escape($item->profile['sex']) == '0')
				{
					echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_SEX_FEMALE'); 
				} elseif ($this->escape($item->profile['sex']) == '1') {
					echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUSER_SEX_MALE'); 
				} else {
                                    echo '_';
                                }
			?>
		</td>
		<td align="center">
			<?php echo empty($item->profile['school']) ? '_' : $this->escape($item->profile['school']); ?>
		</td>
		<?php foreach ($this->docType as $key => $value) :	?>
		<td align="center">
			<?php
                            $valToShow = isset($item->uploadDoc[$key]) ? $item->uploadDoc[$key] : 0;
                            echo $valToShow > 0 ? $valToShow : '_';
			?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
	<tfoot>
		<th colspan="6" align="center"><?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUPLOADDOCUMENT_TOTALBYDOCTYPE_LABEL'); ?></th>
		<?php foreach ($this->docType as $key => $item) :?>
		<th align="center">
		<?php echo JText::_($item["docTypeTotal"]);?>
		</th>
		<?php endforeach; ?>
	</tfoot>