<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LIBRARY_');

?>
<?php if (!isset($this->searchMode) || count($this->documents) > 0) { ?>
<table width="100%">
    <tr>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('TITLE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('UPLOADER'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('UPLOADED_DATE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('SUBJECT'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('CLASS'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TYPE'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('DOWNLOADED_TIMES'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('NO_COMMENTS'); ?></th>
        <th align='center'><?php echo DocumentLibraryHelper::uiText('NO_VERSIONS'); ?></th>
    </tr>
<?php } ?>
<?php if (count($this->documents) > 0) { ?>
    
    <?php foreach ($this->documents as $i => $document) { ?>
    <?php
    $optionArr = array('document' => $document->document_id);
	if ($this->viewAll) {
		$optionArr['viewAll'] = 1;
	}
    	$documentCommentsUrl = DocumentLibraryHelper::url('documentComments', $optionArr);
		$documentDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', $optionArr);
		$documentTreeUrl = DocumentLibraryHelper::url('documentTree', array('document' => $document->document_id));
    ?>
    <tr>
        <td align='center'><?php echo DocumentLibraryHelper::documentNumber($document->original_id, $document->version, $document->document_id); ?></td>
        <td align='center'><a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $document->document_id);?>'><?php echo $document->title; ?></a></td>
        <td align='center'><a href='<?php echo DocumentLibraryHelper::profile($document->uploader_id); ?>'><?php echo $document->user; ?></a></td>
        <td align='center'><?php echo $document->date; ?></td>
        <td align='center'><?php echo $this->subjectModel->getSubjectName($document->subject_id); ?></td>
        <td align='center'><?php echo $this->classModel->getClassName($document->class_id); ?></td>
        <td align='center'><?php echo $this->documentTypeModel->getTypeName($document->type_id); ?></td>
        <td align='center'><a href='<?php echo $documentDownloadsUrl; ?>'><?php echo $this->documentModel->countDownloads($document->document_id); ?></a></td>
        <td align='center'><a href='<?php echo $documentCommentsUrl; ?>'><?php echo $this->documentModel->countComments($document->document_id); ?></a></td>
        <td align='center'><a href='<?php echo $documentTreeUrl; ?>'><?php echo $this->documentModel->countVersions($document->document_id); ?></a></td>
    </tr>
        
    <?php } ?>

<?php } ?>
</table>
