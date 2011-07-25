<?php
defined ('_JEXEC') or die ('Access denied');
function uiText($id) {
    static $TEXT_PREFIX = 'COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LIBRARY_';
    return JText::_($TEXT_PREFIX . $id);
}

?>
<table width="100%">
    <tr>
        <td><?php echo uiText('DOCUMENT_NUMBER'); ?></td>
        <td><?php echo uiText('TITLE'); ?></td>
        <td><?php echo uiText('UPLOADER'); ?></td>
        <td><?php echo uiText('UPLOADED_DATE'); ?></td>
        <td><?php echo uiText('SUBJECT'); ?></td>
        <td><?php echo uiText('CLASS'); ?></td>
        <td><?php echo uiText('DOCUMENT_TYPE'); ?></td>
        <td><?php echo uiText('DOWNLOADED_TIMES'); ?></td>
        <td><?php echo uiText('NO_COMMENTS'); ?></td>
        <td><?php echo uiText('NO_VERSIONS'); ?></td>
    </tr>
    
    <?php foreach ($this->documents as $i => $document) { ?>
    <tr>
        <td><?php echo $document->document_id; ?></td>
        <td><a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&task=document&document=' . $document->document_id);?>'><?php echo $document->title; ?></a></td>
        <td><?php echo $document->user; ?></td>
        <td><?php echo $document->date; ?></td>
        <td><?php echo $this->subjectModel->getSubjectName($document->subject_id); ?></td>
        <td><?php echo $this->classModel->getClassName($document->class_id); ?></td>
        <td><?php echo $this->documentTypeModel->getTypeName($document->type_id); ?></td>
        <td><?php echo $document->no_downloads; ?></td>
        <td><?php echo $this->documentModel->countComments($document->document_id); ?></td>
        <td><?php echo $this->documentModel->countVersions($document->document_id); ?></td>
    </tr>
        
    <?php } ?>
    
</table>