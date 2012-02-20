<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$totalDoc = 0;
$i=$this->pagination->limitstart;
?>
<?php foreach ($this->items as $key => $item) :?>
        <?php $i++; ?>
	<tr class="row<?php echo $i % 2; ?>">
            <td>
                <?php echo $i; ?>
            </td>
		<td>
			<?php echo $this->escape(JText::_($item->name)); ?>
		</td>
		<?php foreach ($this->docType as $key => $value) :	?>
		<td align="center">
			<?php
                                echo  isset($item->uploadStats[$key]) ? $item->uploadStats[$key] : '_';
//				if ($varToShow > 0) {
//                                    $varToShow = '<b><u><i>' . $varToShow . '</i></u></b>';
//                                }
//                                echo $varToShow;
			?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
	<tfoot>
		<th colspan="2" align="center"><?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUPLOADDOCUMENT_TOTALBYDOCTYPE_LABEL'); ?></th>
		<?php foreach ($this->docType as $key => $item) :?>
		<th align="center">
		<?php echo JText::_($item["docTypeTotal"]);?>
		</th>
		<?php endforeach; ?>
	</tfoot>