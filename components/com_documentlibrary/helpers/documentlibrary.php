<?php
defined ('_JEXEC') or die ('Access denied');

abstract class DocumentLibraryHelper {
	private static $uiTextPrefix;
	
	public static function url($task = '', $otherOptions = null, $component = 'com_documentlibrary') {
		$query = 'option=' . $component;
		
		if (!empty($task)) {
			$query .= '&task=' . $task;
		}

		if (!empty($otherOptions)) {
			if (is_array($otherOptions)) {
				foreach ($otherOptions as $key => $value) {
					$query .= '&' . $key . '=' . $value;
				}
			}
		}
	
		if (!empty($query)) {
			$query = '?' . $query;
		}
		
		return JRoute::_('index.php'.$query);
	}
	
	public static function selectionBox($optionsArr, $fieldOptions) {
    	$options = array();
    	$selectBox = '';
    	$name = isset ($fieldOptions['name']) ? $fieldOptions['name'] : 'name' ;
    	$css = isset($fieldOptions['css']) ? $fieldOptions['css'] : 'class="inputbox"';
    	$default = isset($fieldOptions['default']) ? $fieldOptions['default'] : 1;
    
    	foreach ($optionsArr as $key => $value) {
        	$options[] = JHtml::_('select.option', $key, $value);
    	}
    
    	$selectBox = JHtml::_('select.genericlist', $options, $name, $css, 'value', 'text', $default);
    
    	return $selectBox;
	}

	public static function setUiTextPrefix($prefix) {
		DocumentLibraryHelper::$uiTextPrefix = $prefix;
	}
	
	public static function uiText($text) {
		$prefix = DocumentLibraryHelper::$uiTextPrefix;
		if (empty ($prefix)) {
			$prefix = '';
		}
		
		return JText::_($prefix . $text);
	}
}
?>