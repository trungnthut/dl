<?php
defined ('_JEXEC') or die ('Access denied');
?>
<table>
	<tr>
		<td>
			<ol>
				<?php foreach ($listMostInterestedDocument as $i => $doc):?>
					<li>
						<a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $doc->document_id);?>'>						<?php echo $doc->title; ?></a>
						&nbsp;<i>(v<?php echo $doc->version?>)</i>
						&nbsp;<b><?php echo $doc->total_comment?>&nbsp;</b><i><?php echo JText::_("MOD_TEN_MOST_INTERESTED_DOCUMENTS_COMMENT")?></i>
					</li>
				<?php endforeach;?>
			</ol>
		</td>
	</tr>
</table>