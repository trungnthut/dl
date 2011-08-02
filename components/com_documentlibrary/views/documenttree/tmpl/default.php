<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_TREE_');

?>

<?php if ($this->treeMode) { ?>
	<?php
		$documentUrl = DocumentLibraryHelper::url('document', array('document' => $this->document));
	?>
	<p>
		<label><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER');?>:</label>
		<label><?php echo $this->documentNumber; ?></label>
	</p>
	<p>
		<label><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TITLE'); ?>:</label>
		<a href='<?php echo $documentUrl ?>'><?php echo $this->documentTitle; ?></a>
	</p>
<?php } ?>


<?php echo $this->loadTemplate('tree') ?>
