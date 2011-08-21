<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_SEARCH_');

$classSelection = DocumentLibraryHelper::selectionBox($this->classList, array('name' => 'class', 'default'  => $this->defaultClass));
$subjectSelection = DocumentLibraryHelper::selectionBox($this->subjectList, array('name' => 'subject', 'default' => $this->defaultSubject ));

// $quickKeywordSelection = DocumentLibraryHelper::selectionBox($this->quickKeywordTypes, array('name' => 'quick_keyword_type', 'default' => $this->defaultKeywordType));

?>

<form name='search_form' method='POST' action='<?php echo $this->postUrl; ?>'>
	<p>
		<label> <?php echo DocumentLibraryHelper::uiText('LABEL_NORMAL_SEARCH');?>: </label>
		<input type='text' name='quick_keyword' size='70em' value='<?php echo $this->defaultQuickKeyword; ?>'></text>
<!-- 		<?php echo $quickKeywordSelection; ?> -->
	</p>
	
	<p>
		<script type='text/javascript' language='JavaScript'>
			function toggle_advance_search_box() {
				var element = document.getElementById('advance_search_box');
				if (element.style.display == 'block') {
					element.style.display = 'none';
				} else {
					element.style.display = 'block';
				}
				var variable = document.getElementById('advance_box_display');
				variable.value = element.style.display;
			}
		</script>
		<a onClick='toggle_advance_search_box()'><?php echo DocumentLibraryHelper::uiText('LABEL_ADVANCE_SEARCH') ; ?> </a>
		<div id='advance_search_box' style='display: <?php echo $this->advanceBoxDisplay; ?>; padding-left: 1.5em; padding-right: 1.5em'>
			<input type='hidden' name='advance_box_display' id='advance_box_display' value='<?php echo $this->advanceBoxDisplay; ?>' />
<!-- 			<p>
				<label><?php echo DocumentLibraryHelper::uiText('LABEL_KEYWORD');?>: </label>
				<input type='text' name='advance_keyword' size='67em' />
			</p> -->
			
			<p>
				<label><?php echo DocumentLibraryHelper::uiText('LABEL_CLASS'); ?>: </label>
				<?php echo $classSelection; ?>
				&nbsp;&nbsp;
				<label><?php echo DocumentLibraryHelper::uiText('LABEL_SUBJECT'); ?>: </label>
				<?php echo $subjectSelection; ?>
			</p>
			
			<p>
				<label><?php echo DocumentLibraryHelper::uiText('LABEL_DOCUMENT_TYPE'); ?>: </label>
			</p>
			<div style='margin-left: 1.5em; margin-right: 1.5em'>
				<?php echo $this->loadTemplate('document_types'); ?>
			</div>
		</div>
	</p>
	
	<p>
	<?php echo $this->loadTemplate('quick_open'); ?>
	</p>
	
	<p>
		<input type='submit' class='button' name='search' value='<?php echo DocumentLibraryHelper::uiText('BUTTON_SEARCH');?>'/>
		<input type='hidden' name='search' value='1'/>
	</p>

<p>
	<?php
		$this->addTemplatePath(JPATH_COMPONENT . DS . 'views' . DS . 'documentlibrary' . DS . 'tmpl' ); 
		echo $this->loadTemplate('document_list'); 
	?>
</p>

</form>