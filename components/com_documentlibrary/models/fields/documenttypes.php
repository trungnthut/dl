<?php
defined ('_JEXEC') or die ('Access denied');

jimport('joomla.form.helper');
include_once(JPATH_SITE.DS.'components'.DS.'com_documentlibrary'.DS.'models'.DS.'documenttype.php');
include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

class JFormFieldDocumentTypes extends JFormField {
	protected $type='documenttypes';
	private $documentTypeModel;
	private $documentTypes;
	
	function __construct() {
		$this->documentTypeModel = new DocumentLibraryModelDocumentType();
		$this->documentTypes = $this->documentTypeModel->getDocumentTypes();
		// var_dump($this->documentTypes);
	}
	
	function getInput() {
		if (isset($this->element['parent_type'])) {
			return $this->documentTypeModel->getTypeName($this->element['parent_type']);
		} else {
			return $this->getSelectionInput();
		}
	}
	
	function getSelectionInput() {
		$output = "<dl style=''>\n";
		$oldDocument = $this->element['value'];
		// $subTypes = $this->element['subTypeValues'];
		// $subTypes = $this->element['subtypes'];
		$subTypes = JRequest::getVar('documentSubtypes');
		// $checked = ' ';
        foreach ($this->documentTypes as $id => $type ) {
			$output .= "<dt>\n";
			$js = '';
			// $subtype_id = 'documentSubtypes' . $type->type_id;
			$subtype_name = 'documentSubtypes[' . $type->type_id .']';
			// if ($type->extends) {
			// $js="onPropertyChange='document.getElementById(\"${subtype_id}\").disabled=!this.checked;'";
			// }
			$subTypeHTML = "";
			$subChecked = false;

			{
				$selectedSubType = -1;
				$optionsArr = array();
				if ($type->extends) {
					foreach ($type->children as $child) {
						$optionsArr[$child->type_id] = $child->name;
						if ($child->type_id == $oldDocument) {
							$subChecked = true;
							$selectedSubType = $child->type_id;
						}
					}
					$defaultSubType = !empty($subTypes[$type->type_id]) ? $subTypes[$type->type_id] : ($selectedSubType ? $selectedSubType : '');
					$box = DocumentLibraryHelper::selectionBox($optionsArr, array('name' => $subtype_name, 'default' => $defaultSubType));
					$subTypeHTML = $box;
				} 
			}
			$checked =  ($type->type_id == $oldDocument) || $subChecked ? ' checked' : ' ';
			$output .= "<input type='radio' id='documentType" . $type->type_id 
					. "' name='documentType' value='" . $type->type_id . "'" 
					. $checked .">" . $type->name . "</input>\n";
			// $checked = ''; 
			$output .= "</dt>\n";
			
			$output .= "<dd>\n";
			$output .= $subTypeHTML;
			$output .= "</dd>\n";		
		}
		$output .= "</dl>\n";
		return $output;
	}
}

?>