<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');
$i=$this->pagination->limitstart;
?>
<?php foreach ($this->items as $key => $item) :?>
        <?php $i++; ?>
	<tr class="row<?php echo $i % 2; ?>">
            <td align="center">
                <?php echo $i; ?>
            </td>
		<td>
			<?php echo $this->escape($item->username); ?>
		</td>
		<td>
			<?php echo $this->escape($item->name); ?>
		</td>
		<td align='center'>
			<?php echo $this->escape($item->registerDate); ?>
		</td>
		<td align='center'>
			<?php echo !empty($item->profile['subject']) ? JText::_($this->escape($item->profile['subject'])) : '_'; ?>
		</td>
		<td align='center'>
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
                <td align='center'>
                    <?php echo empty($item->totalLogins) ? '_' : $item->totalLogins; ?>
                </td>
	</tr>
<?php endforeach; ?>