<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$totalDoc = 0;
$i=$this->pagination->limitstart;
?>
<?php foreach ($this->items as $key => $item) :?>
	<tr class="row<?php echo $i % 2; ?>">
            <?php $i++; ?>
            <td>
                <?php echo $i; ?>
            </td>
		<td>
			<?php echo $this->escape($item->username); ?>
		</td>
		<td>
			<?php echo $this->escape($item->name); ?>
		</td>
		<?php foreach ($this->docType as $key => $value) :	?>
		<td align="center">
			<?php
                                $valToShow = isset($item->versionUpload[$key]) ? $item->versionUpload[$key] : 0;
				echo $valToShow == '0' ? '_' : $valToShow;
			?>
		</td>
		<?php endforeach; ?>
	</tr>
<?php endforeach; ?>
	<tfoot>
		<th colspan="3" align="center"><?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUPLOADDOCUMENT_TOTALBYDOCTYPE_LABEL'); ?></th>
		<?php foreach ($this->docType as $key => $item) :?>
		<th align="center">
		<?php echo JText::_($item["docTypeTotal"]);?>
		</th>
		<?php endforeach; ?>
	</tfoot>