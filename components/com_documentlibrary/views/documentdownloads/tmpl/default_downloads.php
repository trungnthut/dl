<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_');
?>

<?php if (count($this->documentDownloads) > 0) { ?>
<table width='100%'>
	<tr>
		<th><?php echo DocumentLibraryHelper::uiText('USER'); ?></th>
		<th><?php echo DocumentLibraryHelper::uiText('DATE'); ?></th>
	</tr>

<?php foreach ($this->documentDownloads as $download) { ?>
	<tr>
		<td><?php echo $download->name; ?></td>
		<td><?php echo $download->time; ?></td>
	</tr>
<?php } ?>

</table>
<?php } ?>
