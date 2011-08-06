<?php
defined ('_JEXEC') or die ('Access denied');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOWNLOADS_');
?>

<?php if (count($this->documentDownloads) > 0) { ?>
<table width='100%'>
	<tr>
		<th align="center"><?php echo DocumentLibraryHelper::uiText('NUMBER'); ?></th>
		<th align="center"><?php echo DocumentLibraryHelper::uiText('USER'); ?></th>
		<th align="center"><?php echo DocumentLibraryHelper::uiText('DATE'); ?></th>
		<?php if ($this->viewAll) { ?>
			<th align="center"><?php echo DocumentLibraryHelper::uiText('VERSION'); ?></th>
		<?php } ?>
	</tr>
<?php $id = 0 ?>
<?php foreach ($this->documentDownloads as $download) { ?>
	<?php
		$documentUrl = DocumentLibraryHelper::url('document', array('document' => $download->document_id));
	?>
	<tr>
		<td align="center"><?php echo $this->pager->getRowOffset($id); ?></td> 
		<td align="center"><a href='<?php echo DocumentLibraryHelper::profile($download->user_id); ?>'><?php echo $download->name; ?></a></td>
		<td align="center"><?php echo $download->time; ?></td>
		<?php if ($this->viewAll) { ?>
			<td align="center"><a href='<?php echo $documentUrl; ?>'><?php echo $download->version; ?></a></td>
		<?php } ?>
	</tr>
	<?php $id++ ?>
<?php } ?>

<tfoot>
	<tr>
		<td colspan="4"><?php echo $this->pager->getListFooter(); ?></td>
	</tr>
</tfoot>

</table>
<?php } ?>
