<?php
defined ('_JEXEC') or die();
/**
 * Description of XMLNode
 *
 * @author trungnt
 */
class XMLNode {
    //put your code here
    private $m_type;
    private $m_content;
    private $m_subNodes;
    private $m_attrs;
    private $m_endl;
    
    // constructor
    public function __construct($type = '', $content = '') {
        $this->m_type = $type;
        $this->m_content = $content;
        $this->m_attrs = array();
        $this->m_subNodes = array();
        $this->m_endl = "\n";
    }
    
    public function addAttr($name, $value = '') {
        $this->m_attrs[$name] = $value;
    }
     
    public function addChild(&$node) {
        if (get_class($node) == get_class($this)) {
            $this->m_subNodes[] = $node;
            $node->setEndlChar($this->m_endl);
        }
    }
    
    public function setType($type) {
        $this->m_type = $type;
    }
    
    public function setContent($content) {
        $this->m_content = $content;
    }
    
    public function setEndlChar($endl) {
        $this->m_endl = $endl;
        if (count($this->m_subNodes) > 0) {
            foreach ($this->m_subNodes as $node) {
                $node->setEndlChar($this->m_endl);
            }
        }
    }
    
    public function represent($ident = 0) {
        $str = '';
        $subident = $ident;
        $identstr = '';
        if ($ident >= 0) {
            $subident = $ident + 1;
            for ($i=0 ; $i < $ident ; $i++) {
                $identstr .= ' ';
            }
        }
        
        if (count($this->m_subNodes) <= 0) {
            $str = $this->m_content;
        } else {
            foreach ($this->m_subNodes as $node) {
                $str .= $this->m_endl . $node->represent($ident);
            }
            $str .= $this->m_endl;
        }
        
        $attrStr = $this->genAttrStr();
        $xmlstr = '';
        if (strlen(trim($str)) > 0) {
            $xmlstr = $identstr . '<' . $this->m_type . $attrStr . '>' . $str . $identstr . '</' . $this->m_type . '>';
        } else {
            $xmlstr = $identstr . '<' . $this->m_type . $attrStr . '/>';
        }
        return $xmlstr;
    }
    
    private function genAttrStr() {
        $str = '';
        
        foreach ($this->m_attrs as $name => $value) {
            $str .= ' ' . $name . '="' . $value .'"';
        }
        
        return $str;
    }
}

?>
