<?php
defined ('_JEXEC') or die ('Access denied');
?>

			<ol>
				<?php foreach ($listMostDownloadedDocument as $i => $doc):?>
					<li>
						<a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $doc->document_id);?>'>
						<?php echo $doc->title; ?></a>
						&nbsp;<i>(v<?php echo $doc->version?>)</i>
						&nbsp;<b><?php echo $doc->total_download?>&nbsp;</b><i><?php echo JText::_("MOD_TEN_MOST_DOCUMENTS_DOWNLOAD")?></i>
					</li>
				<?php endforeach;?>
			</ol>