<?php
defined ('_JEXEC') or die ('Access denied');

abstract class DocumentLibraryHelper {
	private static $uiTextPrefix;
	
	public static function url($task = '', $otherOptions = null, $component = 'com_documentlibrary') {
		$query = 'option=' . $component;
		
		if (!empty($task)) {
			$query .= '&view=' . $task;
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
    	$default = isset($fieldOptions['default']) ? $fieldOptions['default'] : 1;
		$disabled = isset($fieldOptions['disabled']) ? $fieldOptions['disabled'] : '';
		$css = isset($fieldOptions['css']) ? $fieldOptions['css'] : 'class="inputbox"';
		$css .= ' ' . $disabled;
    
    	foreach ($optionsArr as $key => $value) {
        	$options[] = JHtml::_('select.option', $key, $value);
    	}
    
    	$selectBox = JHtml::_('select.genericlist', $options, $name, $css, 'value', 'text', $default);
    
    	return $selectBox;
	}

	public static function setUiTextPrefix($prefix) {
		DocumentLibraryHelper::$uiTextPrefix = $prefix;
	}
	
	// public static function uiText($text) {
		// $prefix = DocumentLibraryHelper::$uiTextPrefix;
		// if (empty ($prefix)) {
			// $prefix = '';
		// }
// 		
		// return JText::_($prefix . $text);
	// }
	
	// more customizable version
	// example uiText('document_title', 'view', 'document') => COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_DOCUMENT_TITLE
	// uiText('document_title', 'generic') => COM_DOCUMENT_LIBRARY_GENERIC_DOCUMENT_TITLE
	public static function uiText($text, $type = '', $class = '') {
		static $prefix = 'COM_DOCUMENT_LIBRARY_';
		if (!empty($type)) {
			$type .= '_';
		}
		if (!empty($class)) {
			$class .= '_';
		}
		
		if (!empty($type) || !empty($class)) {
			return JText::_(strtoupper($prefix . $type . $class . $text));
		}
		
		// else old version
		return JText::_(strtoupper(DocumentLibraryHelper::$uiTextPrefix . $text));
	}
	
	public static function documentNumber($original_id, $version, $document_id) {
		// NOTE: future of this one may be some db query
		if ($original_id == 0) {
			$original_id = $document_id;
		}
		return $original_id . '.' . $version;
	}
	
	/**
	 * used to check viewAll request for comments + downloads
	 */
	public static function viewAllValue() {
		$viewAll = JRequest::getVar('viewAll', false);
		if ($viewAll == 'false') {
			$viewAll = false;
		} else if ($viewAll == 'true') {
			$viewAll = true;
		}
		return $viewAll;
	}

	public static function profile($user_id, $edit = false) {
		$query='option=com_users';
		if ($edit) {
			$query .= '&task=profile.edit';
		} else {
			$query .= '&view=profile';
		}
		if ($user_id >0 ) {
			$query .= '&user_id=' . $user_id;
		}

		return JRoute::_('index.php?' . $query);
	}
}
?>
