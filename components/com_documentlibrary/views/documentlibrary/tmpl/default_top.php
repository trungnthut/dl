<?php
defined ('_JEXEC') or die ('Access denied');

$filterLinkPrefix = 'index.php?option=com_documentlibrary&task=documentLibrary';

if ($this->selectedSubjectId > 0) {
    $filterLinkPrefix .= '&subject=' . $this->selectedSubjectId;
    if ($this->selectedClassId > 0) {
        $filterLinkPrefix .= '&class=' . $this->selectedClassId;
    }
}

?>

<p>
    <label><?php echo JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_LIBRARY_FILTER'); ?>:</label>
<?php foreach ($this->documentTypes as $id => $type) { ?>
    <?php $statsString = empty ($this->documentStatsByType[$id]) ? 0 : $this->documentStatsByType[$id]; ?>
    <?php if ($this->filter != $id) { ?>
    <a href="<?php echo $filterLinkPrefix; ?>&filter=<?php echo $id; ?>"><?php echo $type->name; ?> (<?php echo $statsString; ?>)</a>
    <?php } else { ?>
        <label><b><i><?php echo $type->name; ?> (<?php echo $statsString; ?>)</i></b></label>
    <?php } ?>
     &nbsp;
<?php } ?>
</p>