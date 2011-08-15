<?php
defined ('_JEXEC') or die ('Access denied');
?>
<table>
	<tr>
		<td>
			<ol>
				<?php foreach ($listLastestUploadedDocument as $i => $doc):?>
					<li>
						<a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $doc->document_id);?>'>
						<?php echo $doc->title; ?></a>
						&nbsp;<i>(v<?php echo $doc->version?>)</i>
						&nbsp;</b><i>(<?php echo $doc->uploaded_date; ?>)</i>
					</li>
				<?php endforeach;?>
			</ol>
		</td>
	</tr>
</table>