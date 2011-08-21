<?php
defined ('_JEXEC') or die;
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
?>
<?php if (!empty($this->documents)) { ?>
	<table width="100%">
		<tr>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('TITLE', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('UPLOADER', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('UPLOADED_DATE', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('SUBJECT', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('CLASS', 'VIEW', 'FILTER'); ?></th>
        	<th align='center'><?php echo DocumentLibraryHelper::uiText('DOCUMENT_TYPE', 'VIEW', 'FILTER'); ?></th>
        </tr>
	<?php foreach ($this->documents as $document) { ?>
		<tr>
			<td align='center'><?php echo DocumentLibraryHelper::documentNumber($document->original_id, $document->version, $document->document_id); ?></td>
			<td align='center'><a href='<?php echo JRoute::_('index.php?option=com_documentlibrary&view=upload&parent=' . $document->document_id);?>'><?php echo $document->title; ?></a></td>
			<td align='center'><a href='<?php echo DocumentLibraryHelper::profile($document->uploader_id); ?>'><?php echo $document->user; ?></a></td>
			<td align='center'><?php echo $document->date; ?></td>
			<td align='center'><?php echo $this->subjectModel->getSubjectName($document->subject_id); ?></td>
			<td align='center'><?php echo $this->classModel->getClassName($document->class_id); ?></td>
			<td align='center'><?php echo $this->documentTypeModel->getTypeName($document->type_id); ?></td>
		</tr>
	<?php } ?>
	</table>
<?php } ?>
