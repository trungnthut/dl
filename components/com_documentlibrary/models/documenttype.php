<?php
// no direct access
defined ('_JEXEC') or die ('Access denied');

jimport('joomla.application.component.modelitem');

class DocumentLibraryModelDocumentType extends JModelItem {
    private $fixedData;
    private $lastFixedId;
    private $displayData;
    
    private function initFixedData() {
        // if (empty ($this->fixedData)) {
            // $this->fixedData = array(
                // 1 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_DOC',
                // 2 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_VIDEO',
                // 3 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_IMAGE',
                // 4 => 'COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_AUDIO',
            // );
            // $this->lastFixedId = count($this->fixedData);
        // }
        $this->displayData = null;
    }
    
    function getTypeName($id) {
    	if ($id < 0) {
    		return JText::_('COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_INVALID)');
    	}
		if (is_array($this->displayData) && count($this->displayData) > 0) {
			if (array_key_exists($id, $this->displayData)) {
				return JText::_($this->displayData[$id]->name);
			}
		}
		
		$db = JFactory::getDbo();
		$query = 'SELECT name FROM #__document_types WHERE type_id = ' . $id;
		$db->setQuery($query);
		$result = $db->loadResult();
		if (!empty($result)) {
			return JText::_($result);
		} 
		
		return JText::_('COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_INVALID)');
        // if ($id > $this->lastFixedId || $id < 0) {
            // return JText::_("COM_DOCUMENT_LIBRARY_MODEL_DOCUMENT_TYPE_TYPE_INVALID");
        // }
        // if (empty($this->fixedData)) {
            // $this->initFixedData();
        // }
//         
        // return JText::_($this->fixedData[$id]);
    }
    
    function getDocumentTypes() {
    	if (is_array($this->displayData) && count($this->displayData) > 0) {
    		return $this->displayData;
    	}
		
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM #__document_types DT ';
		$db->setQuery($query);
		$result = $db->loadObjectList();
		
		if (count($result) > 0) {
			$this->displayData = array();
			$subtypes = array();
			foreach ($result as $type) {
				$type->name = JText::_($type->name);
				// $this->displayData[$type->type_id] = $type;
				if ($type->parent_id > 0) {
					if (!array_key_exists($type->parent_id, $subtypes)) {
						$subtypes[$type->parent_id] = array();
					}
					$subtypes[$type->parent_id][] = $type;
				} else {
					$this->displayData[$type->type_id] = $type;
					$this->displayData[$type->type_id]->children = null;
				}
			}
			
			foreach ($subtypes as $id => $children) {
				$this->displayData[$id]->children = $children;
			}
		}
		
		return $this->displayData;
        // if (empty($this->fixedData)) {
            // $this->initFixedData();
        // }
//         
        // if (empty ($this->displayData)) {
            // $this->displayData = array();
            // foreach ($this->fixedData as $key => $value) {
                // $this->displayData[$key] = $this->getTypeName($key);
            // }
        // }
//         
        // return $this->displayData;
    }

	function getTypeInfo($id) {
		if ($id < 0) {
			return null;
		}
		
		if (is_array($this->displayData) && array_key_exists($key, $this->displayData)) {
			return $this->displayData[$id];
		}
		
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM #__document_types WHERE type_id = ' . $id;
		$db->setQuery($query);
		return $db->loadObject();
	}
	
	function getSubTypes($id) {
		if ($id < 0) {
			return null;
		}
		
		if (is_array($this->displayData) && count($this->displayData) > 0) {
			if (array_key_exists($id, $this->displayData)) {
				return $this->displayData[$id]->children;
			}
		}
		
		$db = JFactory::getDbo();
		$query = 'SELECT * FROM #__document_types DT WHERE parent_id = ' . $id;
		$db->setQuery($query);
		$result = $db->loadObjectList();
		if (count($result) > 0) {
			return $result;
		} 
		
		return null;
	}
}
?>
