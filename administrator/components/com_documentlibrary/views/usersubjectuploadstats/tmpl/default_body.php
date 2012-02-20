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
			<?php echo $this->escape($item->username); ?>
		</td>
		<td>
			<?php echo $this->escape($item->name); ?>
		</td>
                <td align="center">
                    <?php echo empty($item->profesional) ? '_' : $this->escape(JText::_($item->profesional)); ?>                    
                </td>
		<?php foreach ($this->subjects as $key => $value) :	?>
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
		<th colspan="4" align="center"><?php echo JText::_('COM_DOCUMENTLIBRARY_ADMIN_SUPLOADDOCUMENT_TOTALBYDOCTYPE_LABEL'); ?></th>
		<?php foreach ($this->subjects as $key => $item) :?>
		<th align="center">
		<?php echo JText::_($item["total"]);?>
		</th>
		<?php endforeach; ?>
	</tfoot>