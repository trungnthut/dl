<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LIBRARY_');

?>
<?php if (count($this->documents) > 0) { ?>
<table width="100%">
    <tr>
        <td><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('TITLE'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('UPLOADER'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('UPLOADED_DATE'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('SUBJECT'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('CLASS'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TYPE'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('DOWNLOADED_TIMES'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('NO_COMMENTS'); ?></td>
        <td><?php echo DocumentLibraryHelper::uiText('NO_VERSIONS'); ?></td>
    </tr>
    
    <?php foreach ($this->documents as $i => $document) { ?>
    <?php
    	$documentCommentsUrl = DocumentLibraryHelper::url('documentComments', array('document' => $document->document_id, 'viewAll' => 1));
		$documentDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $document->document_id));
		$documentTreeUrl = DocumentLibraryHelper::url('documentTree', array('document' => $document->document_id));
    ?>
    <tr>
        <td><?php echo $document->document_id; ?></td>
        <td><a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $document->document_id);?>'><?php echo $document->title; ?></a></td>
        <td><?php echo $document->user; ?></td>
        <td><?php echo $document->date; ?></td>
        <td><?php echo $this->subjectModel->getSubjectName($document->subject_id); ?></td>
        <td><?php echo $this->classModel->getClassName($document->class_id); ?></td>
        <td><?php echo $this->documentTypeModel->getTypeName($document->type_id); ?></td>
        <td><a href='<?php echo $documentDownloadsUrl; ?>'><?php echo $document->no_downloads; ?></a></td>
        <td><a href='<?php echo $documentCommentsUrl; ?>'><?php echo $this->documentModel->countComments($document->document_id); ?></a></td>
        <td><a href='<?php echo $documentTreeUrl; ?>'><?php echo $this->documentModel->countVersions($document->document_id); ?></a></td>
    </tr>
        
    <?php } ?>
    
</table>

<?php } ?>