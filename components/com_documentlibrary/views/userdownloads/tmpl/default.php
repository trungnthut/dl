<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_USER_DOWNLOADS_');

$idx = 0;
?>
<?php if (count($this->userDownloads) > 0) { ?>
	<fieldset>
		<legend><?php JText::printf('COM_DOCUMENT_LIBRARY_VIEW_USER_DOWNLOADS_BY_USER', $this->userName); ?></legend>
<table width="100%">
    <tr>
    	<th align='center'><?php echo DocumentLibraryHelper::uiText('NUMBER'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('TITLE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOWNLOADED_DATE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TYPE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOWNLOADED_TIMES'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('NO_COMMENTS'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('NO_VERSIONS'); ?></th>
    </tr>
    
    <?php foreach ($this->userDownloads as $download) { ?>
    <?php
    $idx++;
	$document = $this->documents[$download->document_id];
    $optionArr = array('document' => $download->document_id);
	if ($this->viewAll) {
		$optionArr['viewAll'] = 1;
	}
    	$documentCommentsUrl = DocumentLibraryHelper::url('documentComments', $optionArr);
		$documentDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', $optionArr);
		$documentTreeUrl = DocumentLibraryHelper::url('documentTree', array('document' => $document->document_id));
    ?>
    <tr>
    	<td align='center'><?php echo $idx; ?></td>
        <td align='center'><?php echo DocumentLibraryHelper::documentNumber($document->original_id, $document->version, $document->document_id); ?></td>
        <td align='center'><a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $document->document_id);?>'><?php echo $document->title; ?></a></td>
        <td align='center'><?php echo $download->date; ?></td>
        <td align='center'><?php echo JText::_($document->type); ?></td>
        <td align='center'><a href='<?php echo $documentDownloadsUrl; ?>'><?php echo $this->documentModel->countDownloads($document->document_id); ?></a></td>
        <td align='center'><a href='<?php echo $documentCommentsUrl; ?>'><?php echo $this->documentModel->countComments($document->document_id); ?></a></td>
        <td align='center'><a href='<?php echo $documentTreeUrl; ?>'><?php echo $this->documentModel->countVersions($document->document_id); ?></a></td>
    </tr>
        
    <?php } ?>
    
</table>
</fieldset>

<?php } ?>