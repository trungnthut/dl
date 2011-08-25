<?php
defined ('_JEXEC') or die;
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_SEARCH_');

$quickOpenUrl = JRoute::_('index.php?option=com_documentlibrary&task=openDocumentByNumber');
?>
	<div id='open_warning' style='display: none; background-color:yellow; border: 1px solid orange; padding: 0.7em'>
	<?php echo DocumentLibraryHelper::uiText('EMPTY_NUMBER'); ?>
	</div>
	<p>
		<script type='text/javascript' language='javascript'>
			function showError() {
				var messageArea = document.getElementById('open_warning');
				messageArea.style.display = 'block';
				setTimeout('hideError()', 4000);
			}
			function hideError() {
				var messageArea = document.getElementById('open_warning');
				messageArea.style.display = 'none';
			}
			function openDocument() {
				var documentNumber = document.getElementById('document_number').value.replace(/^\s+|\s+$/g, '');
				if (documentNumber == '') {
					showError();
				} else {
					postRequest(documentNumber);
				}
			}
			function postRequest(documentNumber) {
				var openForm = document.createElement('form');
				openForm.method = 'post';
				openForm.action = '<?php echo $quickOpenUrl; ?>';
				var input = document.createElement('input');
				input.name = 'document_number';
				input.type = 'hidden';
				input.value = documentNumber;
				openForm.appendChild(input);
				document.body.appendChild(openForm);
				openForm.submit();
			}
		</script>
		<label><?php echo DocumentLibraryHelper::uiText('DOCUMENT_NUMBER') ?>:</label>
		&nbsp;&nbsp;
		<input type='text' id='document_number'>
		&nbsp;&nbsp;
		<input type='button' name='quick_open' class='button' value='<?php echo DocumentLibraryHelper::uiText('QUICK_OPEN'); ?>' onClick='openDocument()'>
	</p>
