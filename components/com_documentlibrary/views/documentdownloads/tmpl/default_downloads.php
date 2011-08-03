<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_');
?>

<?php if (count($this->documentDownloads) > 0) { ?>
<table width='100%'>
	<tr>
		<th align="center"><?php echo DocumentLibraryHelper::uiText('USER'); ?></th>
		<th align="center"><?php echo DocumentLibraryHelper::uiText('DATE'); ?></th>
		<?php if ($this->viewAll) { ?>
			<th align="center"><?php echo DocumentLibraryHelper::uiText('VERSION'); ?></th>
		<?php } ?>
	</tr>

<?php foreach ($this->documentDownloads as $download) { ?>
	<?php
		$documentUrl = DocumentLibraryHelper::url('document', array('document' => $download->document_id));
	?>
	<tr>
		<td align="center"><?php echo $download->name; ?></td>
		<td align="center"><?php echo $download->time; ?></td>
		<?php if ($this->viewAll) { ?>
			<td align="center"><a href='<?php echo $documentUrl; ?>'><?php echo $download->version; ?></a></td>
		<?php } ?>
	</tr>
<?php } ?>

</table>
<?php } ?>
