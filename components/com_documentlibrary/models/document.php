<?php
defined ('_JEXEC') or die ('Access denied');

jimport ('joomla.application.component.modelitem');

class DocumentLibraryModelDocument extends JModelItem {
    private $document_id;
    private $version_list;
    
    function __construct($config = array()) {
        parent::__construct($config);
        $this->document_id = 0;
        $this->version_list = array();
    }
    
    function getDocumentInfo($id = 0) {
        if ($id <= 0) {
            $id = JRequest::getVar('document', -1);
        }
        if ($id <= 0) {
            return null;
        }
        
        $db = JFactory::getDbo();
        $query = 'SELECT D.*, DATE(D.uploaded_time) AS date, U.name, COUNT(DD.download_id) AS no_downloads' 
                .' FROM #__users U, #__documents D'
                .' LEFT JOIN #__document_downloads DD ON DD.document_id = D.document_id'
                .' WHERE D.uploader_id = U.id AND D.document_id = ' . $id
                .' GROUP BY DD.document_id';
        $db->setQuery($query);
        
        return $db->loadObject();
    }
    
    private function listUpdates($id) {
        if ($id <= 0) {
            return 0;
        }
        
        $db = JFactory::getDbo();
        $query = 'SELECT document_id FROM #__documents WHERE original_id = ' . $id;
        $db->setQuery($query);
        
        return $db->loadResultArray();
    }
    
    function versionList($id) {
        if ($id <= 0) {
            return array();
        }
        
        if ($this->document_id == $id || in_array($id, $this->version_list)) {
            return $this->version_list;
        }
        
        // get it's original_id
        $original_id = 0;
        {
            $db = JFactory::getDbo();
            $query = 'SELECT original_id FROM #__documents WHERE document_id = ' . $id;
            $db->setQuery($query);
            $original_id = $db->loadResult();
        }
        
        if ($original_id == 0) {
            // this's the original document then
            $original_id = $id;
        }
        
        $this->version_list = array($original_id);
        $this->version_list = array_merge($this->version_list, $this->listUpdates($original_id));
        
        return $this->version_list;
    }
    
    /**
     * TODO: Should check and replace this one by getNoVersion()
     * @param type $id
     * @return type 
     */
    function countVersions($id) {
        return count ($this->versionList($id));
    }
    
    function getNoVersions($id = 0) {
        if ($id <= 0) {
            $id = JRequest::getVar('document', 0);
        }
        if ($id <= 0) {
            return 0;
        }
        
        return $this->countVersions($id);
    }
    
    private function countCommentsForOneDocument($id) {
        if ($id < 0) {
            return 0;
        }
        
        $db = JFactory::getDbo();
        $query = 'SELECT COUNT(comment_id) FROM #__document_comments WHERE document_id = ' . $id;
        $db->setQuery($query);
        
        return $db->loadResult();
    }
    
    /**
     * TODO: Should check and replace this one by getNoComments()
     * @param type $id
     * @return type 
     */
    function countComments($id) {
        $ids = $this->versionList($id);
		$viewAll = DocumentLibraryHelper::viewAllValue();
		if ($viewAll) {
			$ids = $this->versionList($id);
		} else {
			$ids = array($id);
		}
        $count = 0;

		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(comment_id) FROM #__document_comments WHERE document_id IN (' . implode(',', $ids) . ') AND poster_id > 0';
        $db->setQuery($query);
        
        return $db->loadResult();
    }
    
    function getNoComments($id = -1) {
        if ($id <= 0) {
            $id = JRequest::getVar('document', 0);
        }
        if ($id <= 0) {
            return 0;
        }
        
        return $this->countComments($id);
    }
    
//    function getFileName($id = -1) {
//        if ($id <= 0) {
//            $id = JRequest::getVar('document', 0);
//        }
//        if ($id <= 0) {
//            return '';
//        }
//        
//        $db = JFactory::getDbo();
//        $query = 'SELECT fileName FROM #__documents WHERE document_id = ' . $id;
//        $db->setQuery($query);
//        
//        return $db->loadResult();
//    }
    function insertDownload($obj) {
        $db = JFactory::getDbo();
        $db->insertObject('#__document_downloads', $obj, 'download_id');
        return $db->insertid();
    }
	
	// function getNoDownloads($id = 0) {
		// if ($id <= 0) {
            // $id = JRequest::getVar('document', 0);
        // }
        // if ($id <= 0) {
            // return 0;
        // }
        // // temporary for now
        // $db = JFactory::getDbo();
		// $query = 'SELECT COUNT(download_id) FROM #__document_downloads WHERE document_id = ' . $id;
		// $db->setQuery($query);
// 		
		// $result = $db->loadObject();
		// var_dump($result);
// 		//what's wrong ?
		// return $db->loadResult();
	// }
	
	function getVersionTree($id = 0) {
		if ($id <= 0) {
			$id = JRequest::getVar('document', 0);
		}
		
		if ($id <= 0) {
			return null;
		}

		$original_id = 0;
        {
            $db = JFactory::getDbo();
            $query = 'SELECT original_id FROM #__documents WHERE document_id = ' . $id;
            $db->setQuery($query);
            $original_id = $db->loadResult();
        }
		if ($original_id == 0) {
			$original_id = $id;
		}
		
		$root = new stdClass();
		$root->id = $original_id;
		$root->version = $original_id . '.1';
		$root->children = array();
		$tree = array();
		$tree[$original_id] = $root;
		
		$nodesInfo = $this->getChildrenOf($original_id);
		
		while (!empty($nodesInfo)) {
			foreach ($nodesInfo['tree'] as $child => $info) {
				$parent = $info['parent'];
				$node = new stdClass();
				$node->id = $child;
				$node->version = $original_id . '.' . $info['version'];
				$tree[$child] = $node;
				$tree[$parent]->children[] = $node;
			}
			$new_parents = $nodesInfo['children'];
			$nodesInfo = $this->getChildrenOf($new_parents);
		}
		
		return $root;
	}
	
	function getChildrenOf($ids = null) {
		if (empty($ids)) {
			return null;
		}
		if (!is_array($ids)) {
			$ids = array($ids);
		}
		
		$db = JFactory::getDbo();
		$query = 'SELECT document_id, parent_id, version FROM #__documents WHERE parent_id IN (' . implode(',', $ids) . ')';
		$db->setQuery($query);
		$nodes = $db->loadRowList();
		if (empty($nodes)) {
			return null;
		}
		$subtree = array();
		$children = array();
		foreach ($nodes as $node) {
			$children[] = $node[0];
			$subtree[$node[0]] = array('parent' => $node[1], 'version' => $node[2]);
		}
		
		return array('children' => $children, 'tree' => $subtree);
	}
	
	function countDownloads($id) {
        $ids = $this->versionList($id);
		$viewAll = DocumentLibraryHelper::viewAllValue();
		if ($viewAll) {
			$ids = $this->versionList($id);
		} else {
			$ids = array($id);
		}
        $count = 0;

		$db = JFactory::getDbo();
		$query = 'SELECT COUNT(download_id) FROM #__document_downloads WHERE document_id IN (' . implode(',', $ids) . ') AND user_id > 0';
        $db->setQuery($query);
        
        return $db->loadResult();
    }
	
	function getNoDownloads($id = 0) {
		if ($id <= 0) {
            $id = JRequest::getVar('document', 0);
        }
        if ($id <= 0) {
            return 0;
        }
        
        return $this->countDownloads($id);
	}
    
}
?>
