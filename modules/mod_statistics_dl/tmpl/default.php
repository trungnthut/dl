<?php
defined ('_JEXEC') or die ('Access denied');
?>
<table>
	<tr>
		<td>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_UPLOADED_DOCUMENTS');?>:&nbsp;<b><?php echo $totalDocuments?></b><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_MEMBERS');?>:&nbsp;<?php echo $totalMembers?><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_LOGINS');?>:&nbsp;<?php echo $totalLogins?><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_ONLINE_MEMBERS');?>:&nbsp;<?php echo $totalUserOnlines?><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_GUESTS');?>:&nbsp;<?php echo $totalGuests?><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_COMMENTS');?>:&nbsp;<?php echo $totalComments?><br>
			<?php echo JText::_('MOD_STATISTICS_TOTAL_DOWNLOADS');?>:&nbsp;<?php echo $totalDownloads?><br>
		</td>
	</tr>
</table>