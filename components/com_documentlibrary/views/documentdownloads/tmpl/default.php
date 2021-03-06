<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_');

$switchModeUrl = '';
$switchModeText = '';
if ($this->viewAll) {
	$switchModeUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $this->document_id));
	$switchModeText = DocumentLibraryHelper::uiText('THIS_VERSION_COMMENTS');
} else {
	$switchModeUrl = DocumentLibraryHelper::url('documentDownloads', array('document' => $this->document_id, 'viewAll' => 1));
	$switchModeText = DocumentLibraryHelper::uiText('ALL_VERSION_COMMENTS');
}

?>

<?php if ($this->downloadsMode) { ?>
	<?php
		$documentUrl = DocumentLibraryHelper::url('document', array('document' => $this->document_id));
	?>
	<p>
		<label><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER');?>:</label>
		<label><?php echo $this->documentNumber; ?></label>
	</p>
	<p>
		<label><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TITLE'); ?>:</label>
		<a href='<?php echo $documentUrl ?>'><?php echo $this->documentTitle; ?></a>
	</p>
	
	<p>
		<label><?php echo DocumentLibraryHelper::uiText('NUM_DOWNLOADS'); ?>:</label>
		<label><?php echo $this->numDownloads; ?></label>
	</p>
	
	<p>
		<a href='<?php echo $switchModeUrl; ?>'><?php echo $switchModeText?></a>
	</p>
<?php } ?>

<?php echo $this->loadTemplate('downloads'); ?>
