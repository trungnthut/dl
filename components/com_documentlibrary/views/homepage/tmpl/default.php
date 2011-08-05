<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function uiText($text) {
    return JText::_('COM_DOCUMENT_LIBRARY_VIEW_HOMEPAGE_' . $text);
}
?>
<table width='100%' cellpadding='10'>
	<tr>
		<td width='70%'>
			<table width="100%">
				<tr>
					<td>
						<b><?php echo uiText('INTRO');?></b><br>
						<?php echo uiText('INTRO_DETAILS');?><br><br />
						<b><?php echo uiText('MANUALS');?></b><br>
						<?php echo uiText('MANUALS_DETAILS');?><br><br />
						<b><?php echo uiText('SCORING_SYSTEM_INTRO');?></b><br>
						<?php echo uiText('SCORING_SYSTEM_INTRO_DETAILS');?><br><br />
					</td>
				</tr>
				<tr>
					<td>
						<b><?php echo uiText('EDUCATION_INFO');?></b><br><br />
					</td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td>
						<b><?php echo uiText('TEN_MOST_INTERESTED_DOCUMENTS');?></b>
						<ol>
						<?php foreach ($this->listMostInterestedDocument as $i => $doc):?>
							<li>
								<a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $doc->document_id);?>'>
								<?php echo $doc->title; ?></a>
								&nbsp;<i>(v<?php echo $doc->version?>)</i>
								&nbsp;<b><?php echo $doc->total_comment?>&nbsp;</b><i>comments</i>
							</li>
						<?php endforeach;?>
						</ol>
					</td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td>
						<b><?php echo uiText('TEN_LASTEST_UPLOADED_DOCUMENTS');?></b><br />
						<ol>
						<?php foreach ($this->listLastestUploadedDocument as $i => $doc):?>
							<li>
								<a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $doc->document_id);?>'>
								<?php echo $doc->title; ?></a>
								&nbsp;<i>(v<?php echo $doc->version?>)</i>
								&nbsp;uploaded by <b><?php echo $doc->uploader?>&nbsp;</b><i>(<?php echo $doc->uploaded_date; ?>)</i>
							</li>
						<?php endforeach;?>
						</ol>
					</td>
				</tr>
			</table>
		</td>
		<td valign="top">
			<table width="100%">
				<tr>
					<td>
						<a href="<?php echo $this->uploadUrl; ?>"><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_UPLOAD_NEW_DOCUMENT');?></a>
					</td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td>
						<input type='text'>&nbsp;<input type="button" value="Search"><br>
						Advanced Search&nbsp;<input type='text'><br>
						Tìm kiếm theo số tài liệu:
					</td>
				</tr>
			</table>
			<table width="100%">
				<tr>
					<td>
						<?php echo $this->currentDate?><br>
						<?php echo uiText('TOTAL_UPLOADED_DOCUMENTS');?>:&nbsp;<b><?php echo $this->totalDocument->total_document?></b><br>
						<?php echo uiText('TOTAL_MEMBERS');?>:&nbsp;<br>
						<?php echo uiText('TOTAL_LOGINS');?>:&nbsp;<br>
						<?php echo uiText('TOTAL_ONLINE_MEMBERS');?>:&nbsp;<br>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
