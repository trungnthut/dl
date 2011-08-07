<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function uiText($text) {
    return JText::_('COM_DOCUMENT_LIBRARY_VIEW_HOMEPAGE_' . $text);
}
?>
<table width='100%' cellpadding='10'>
				<tr>
					<td colspan="2">
						<b><?php echo uiText('INTRO');?></b><br>
						<?php echo uiText('INTRO_DETAILS');?><br><br />
						<b><?php echo uiText('MANUALS');?></b><br>
						<?php echo uiText('MANUALS_DETAILS');?><br><br />
						<b><?php echo uiText('SCORING_SYSTEM_INTRO');?></b><br>
						<?php echo uiText('SCORING_SYSTEM_INTRO_DETAILS');?><br><br />
					</td>
					<td>
						<a href="<?php echo $this->uploadUrl; ?>"><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_UPLOAD_NEW_DOCUMENT');?></a>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<b><?php echo uiText('EDUCATION_INFO');?></b><br><br />
					</td>
					<td>
						<form name="frmSearch" method="post" action="<?php echo $this->searchURL?>">
							<input type='hidden' name="quick_keyword_type" value="1"/>
							<input type='text' name="quick_keyword"/>&nbsp;<input type="submit" name="search" value="Search"/>
							<br>
						</form>
						<a href="<?php echo JRoute::_($this->advancedSearchURL);?>"><?php echo uiText('ADVANCED_SEARCH');?></a>
						<br>
						<form name="frmSearch2" method="post" action="<?php echo $this->openByNumberUrl?>">
							<label><?php echo uiText('OPEN_DOCUMENT_BY_VERSION');?></label>
							<input type='text' name="document_number"/>&nbsp;<input type="submit" name="" value="<?php echo uiText('OPEN'); ?>">
							<br>
						</form>
					</td>
				</tr>
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
					
					<td>
						<?php echo $this->currentDate?><br>
						<?php echo uiText('TOTAL_UPLOADED_DOCUMENTS');?>:&nbsp;<b><?php echo $this->totalDocument->total_document?></b><br>
						<?php echo uiText('TOTAL_MEMBERS');?>:&nbsp;<br>
						<?php echo uiText('TOTAL_LOGINS');?>:&nbsp;<br>
						<?php echo uiText('TOTAL_ONLINE_MEMBERS');?>:&nbsp;<br>
					</td>
					
				</tr>
			</table>

