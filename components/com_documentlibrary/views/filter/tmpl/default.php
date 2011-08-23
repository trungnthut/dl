<?php
defined ('_JEXEC') or die;
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

?>
<form method='POST'>
<fieldset>
	<legend><?php echo DocumentLibraryHelper::uiText('FILTER_TITLE', 'VIEW', 'FILTER'); ?></legend>
	<dl>
		<dt><?php echo DocumentLibraryHelper::uiText('LABEL_TITLE', 'VIEW', 'FILTER'); ?></dt>
		<dd><input type='text' name='title' size="70" value='<?php echo  $this->currentTitle; ?>'/></dd>
		<dt><?php echo DocumentLibraryHelper::uiText('LABEL_SUBJECT', 'VIEW', 'FILTER'); ?></dt>
		<dd><?php echo DocumentLibraryHelper::selectionBox($this->subjects, array('name' => 'subject', 'default' => $this->defaultSubject )); ?></dd>
		<dt><?php echo DocumentLibraryHelper::uiText('LABEL_CLASS', 'VIEW', 'FILTER'); ?></dt>
		<dd><?php echo DocumentLibraryHelper::selectionBox($this->classes, array('name' => 'class', 'default' => $this->defaultClass)); ?></dd>
		<dt><?php echo DocumentLibraryHelper::uiText('LABEL_TYPE', 'VIEW', 'FILTER'); ?></dt>
		<dd><?php echo DocumentLibraryHelper::selectionBox($this->types, array('name' => 'type', 'default' => $this->defaultType)); ?></dd>
	</dl>
</fieldset>
<input type='submit' class='button' name='search' value='<?php echo DocumentLibraryHelper::uiText('LABEL_FILTER', 'VIEW', 'FILTER'); ?>'/>
<input type='hidden' name='search' value='1'/>
<p>
	<?php echo $this->loadTemplate('documents'); ?>
</p>
</form>