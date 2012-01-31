<?php
defined ('_JEXEC') or die();

class KunenaCategory {
    private $cat_id;
    private $parent;
    private $name;
    private $children;
    private static $categories;
    private static $root;
    
    function __construct($id, $parent = 0, $name = '') {
        $this->cat_id = $id;
        $this->parent = $parent;
        $this->name = $name;
        $this->children = array();
        KunenaCategory::$categories[$id] = $this;
        // looks for the parent
        if (isset(KunenaCategory::$categories[$parent])) {
            KunenaCategory::$categories[$parent]->addChild($this);
        }
    }
    
    function setId($id) {
        $this->cat_id = $id;
    }
    
    function id() {
        return $this->cat_id;
    }
    
    function setParent($parent) {
        $this->parent = $parent;
    }
    
    function parent() {
        return $this->parent;
    }
    
    function setName($name) {
        $this->name = $name;
    }
    
    function name() {
        return $this->name;
    }
    
    function addChild($cat) {
        $this->children[] = $cat;
    }
    
    function children() {
        return $this->children;
    }
    
    public static function queryCategories() {
        KunenaCategory::$categories = array();
        KunenaCategory::$root = new KunenaCategory(0, -1, 'forum');
        
        $query = 'SELECT id, parent, name FROM #__kunena_categories';
        $db = JFactory::getDbo();
        $db->setQuery($query);
        $res = $db->loadObjectList();
        
        foreach ($res as $cat) {
            $myCat = new KunenaCategory($cat->id, $cat->parent, $cat->name);
        }
        
//        var_dump(KunenaCategory::$root);
        
        return KunenaCategory::$root;
    }
    
    public static function getCategory($id) {
        return KunenaCategory::$categories[$id];
    }
}
?>
