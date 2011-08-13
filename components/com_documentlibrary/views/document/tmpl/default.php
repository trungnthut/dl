<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function uiText($text) {
    return JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_' . $text);
}

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_');

$documentTreeUrl = DocumentLibraryHelper::url('documentTree', array('document' => $this->documentInfo->document_id));
$allVersionCommentsUrl = DocumentLibraryHelper::url('documentComments', array('document' => $this->documentInfo->document_id, 'viewAll' => 1));
$thisVersionDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $this->documentInfo->document_id));
$allVersionDownloadsUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $this->documentInfo->document_id, 'viewAll' => 1));

?>
<fieldset>
	<legend><?php echo DocumentLibraryHelper::uiText('LABEL_DOCUMENT_INFO'); ?></legend>
<!-- <p> -->
	<dl>
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_DOCUMENT_NUMBER');?>:</dt>
    <dd><?php echo $this->documentNumber; ?>.<?php echo $this->documentVersion; ?></dd>
<!-- </p> -->

<!--<p>
    <label><?php //echo uiText('LABEL_DOCUMENT_VERSION'); ?>:</label>
    <label><?php //echo $this->documentVersion; ?></label>
</p>-->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_TITLE'); ?>:</dd>
    <dd><?php echo $this->documentTitle; ?></dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LABEL_SUMMARY'); ?>:</dt>
    <dd><?php echo $this->documentSummary; ?></dd>
<!-- </p> -->

<!-- <br/> -->
<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_QUESTION');?>:</dt>
    <dd><?php echo $this->documentQuestion; ?></dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_UPLOADER');?>:</dt>
    <dd><a href='<?php echo DocumentLibraryHelper::profile($this->documentUploaderId);?>'><?php echo $this->documentUploader; ?></a></dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DATE');?>:</dt>
    <dd><?php echo $this->documentDate; ?></dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADED_TIMES');?>:</dt>
    <dd><a href='<?php echo $thisVersionDownloadsUrl; ?>'><?php echo $this->documentDownloadedTimes; ?></a>
    (<a href='<?php echo $allVersionDownloadsUrl?>'><?php echo  DocumentLibraryHelper::uiText('ALL_VERSION_DOWNLOADS', 'view', 'document'); ?></a>)</dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_NO_COMMENTS');?>:</dd>
    <dd><label><?php echo $this->documentNoComments; ?></label>
    (<a href='<?php echo $allVersionCommentsUrl;?>'><?php echo DocumentLibraryHelper::uiText('ALL_VERSION_COMMENTS', 'view', 'document'); ?></a>)</dd>
<!-- </p> -->

<!-- <p> -->
    <dt><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_NO_VERSIONS');?>:</dt>
    <dd><a href='<?php echo $documentTreeUrl; ?>'><?php echo $this->documentNoVersions; ?></a></dd>
<!-- </p> -->
</dl>

<p>
<!--    <label>Noi dung tai lieu</label>-->
</p>
<p>
    <?php
        $upload_url = JRoute::_('index.php?option=com_documentlibrary&task=upload');
        $upload_new_version_url = JRoute::_('index.php?option=com_documentlibrary&task=upload&parent=' . $this->documentId);
        $download_url = JRoute::_('index.php?option=com_documentlibrary&task=download&document=' . $this->documentId);
    ?>
    <a class="button" href="<?php echo $upload_url; ?>"><?php echo uiText('UPLOAD_NEW_DOCUMENT'); ?></a>
    &nbsp;&nbsp;&nbsp;
    <a class="button" href="<?php echo $upload_new_version_url; ?>"><?php echo uiText('UPLOAD_NEW_VERSION'); ?></a>
    &nbsp;&nbsp;&nbsp;
    <a class="button" href="<?php echo $download_url; ?>"><?php echo uiText('DOWNLOAD'); ?></a>
</p>

</fieldset>

<p>
    <?php echo $this->loadTemplate('post_comment');?>
</p>

<p>
    <?php
		$this->addTemplatePath(JPATH_COMPONENT . DS . 'views' . DS . 'documentcomments' . DS . 'tmpl' ); 
		echo $this->loadTemplate('comments'); 
	?>
</p>