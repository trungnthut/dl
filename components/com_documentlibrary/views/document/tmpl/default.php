<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function uiText($text) {
    return JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_' . $text);
}

$documentDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $this->documentInfo->document_id));
$documentTreeUrl = DocumentLibraryHelper::url('documentTree', array('document' => $this->documentInfo->document_id));

?>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_DOCUMENT_NUMBER');?>:</label>
    <label><?php echo $this->documentNumber; ?>.<?php echo $this->documentVersion; ?></label>
</p>

<!--<p>
    <label><?php //echo uiText('LABEL_DOCUMENT_VERSION'); ?>:</label>
    <label><?php //echo $this->documentVersion; ?></label>
</p>-->

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_TITLE'); ?>:</label>
    <label><?php echo $this->documentTitle; ?></label>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_SUMMARY'); ?>:</label>
    <label><?php echo $this->documentSummary; ?></label>
</p>

<br/>
<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_QUESTION');?>:</label>
    <label><?php echo $this->documentQuestion; ?></label>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_UPLOADER');?>:</label>
    <label><?php echo $this->documentUploader; ?></label>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DATE');?>:</label>
    <label><?php echo $this->documentDate; ?></label>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADED_TIMES');?>:</label>
    <a href='<?php echo $documentDownloadsUrl; ?>'><?php echo $this->documentDownloadedTimes; ?></a>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_NO_COMMENTS');?>:</label>
    <label><?php echo $this->documentNoComments; ?></label>
</p>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_NO_VERSIONS');?>:</label>
    <a href='<?php echo $documentTreeUrl; ?>'><?php echo $this->documentNoVersions; ?></a>
</p>

<p>
<!--    <label>Noi dung tai lieu</label>-->
</p>

<p>
    <?php
        $upload_url = JRoute::_('index.php?option=com_documentlibrary&task=upload');
        $upload_new_version_url = JRoute::_('index.php?option=com_documentlibrary&task=upload&parent=' . $this->documentId);
        $download_url = JRoute::_('index.php?option=com_documentlibrary&task=download&document=' . $this->documentId);
    ?>
    <a href="<?php echo $upload_url; ?>"><?php echo uiText('UPLOAD_NEW_DOCUMENT'); ?></a>
    &nbsp;&nbsp;&nbsp;
    <a href="<?php echo $upload_new_version_url; ?>"><?php echo uiText('UPLOAD_NEW_VERSION'); ?></a>
    &nbsp;&nbsp;&nbsp;
    <a href="<?php echo $download_url; ?>"><?php echo uiText('DOWNLOAD'); ?></a>
</p>

<p>
    <?php echo $this->loadTemplate('post_comment');?>
</p>

<p>
    <?php
		$this->addTemplatePath(JPATH_COMPONENT . DS . 'views' . DS . 'documentcomments' . DS . 'tmpl' ); 
		echo $this->loadTemplate('comments'); 
	?>
</p>