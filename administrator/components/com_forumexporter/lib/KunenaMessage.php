<?php
defined ('_JEXEC') or die();
require_once(KPATH_SITE.'/lib/kunena.timeformat.class.php');
require_once('XMLNode.php');

class KunenaMessage {
    private $id;
    private $dateTime;
    private $author;
    private $subject;
    private $contents;
    private $ref;
    private static $refData = array();
    
    function __construct() {
        $this->id = 0;
        $this->dateTime = "";
        $this->author = "";
        $this->subject = "";
        $this->contents = "";
        $this->ref = 0;
    }
    
    function setDateTime($dateTime) {
        $this->dateTime = $dateTime;
    }
    
    function setAuthor($author) {
        $this->author = $author;
    }
    
    function setSubject($subject) {
        $this->subject = $subject;
    }
    
    function setContents($contents) {
        $this->contents = $contents;
    }
    
    function setRef($ref) {
        $this->ref = $ref;
    }
    
    function fromObject($object) {
        if (property_exists($object, 'id')) {
            $this->id = $object->id;
        }
        if (property_exists($object, 'subject')) {
            $this->subject = $object->subject;
        }
        if (property_exists($object, 'postTime')) {
            $date = JFactory::getDate($object->postTime);
            $this->dateTime = $date->toFormat();
        }
        if (property_exists($object, 'parent')) {
            $this->ref = KunenaMessage::getRefId($this->id, $object->parent);
        }
        if (property_exists($object, 'userid')) {
            $user = JFactory::getUser($object->userid);
            $this->author = $user->username;
        }
        if (property_exists($object, 'message')) {
            $this->contents = $object->message;
        }
    }
    
    public static function getRefId($id, $parent) {
        if ($id <= 0) {
            return -1;
        }
        if ($parent == 0) {
            KunenaMessage::$refData[$id] = $id;
            return 0;
        }
        if (isset (KunenaMessage::$refData[$parent])) {
            $lastRef = KunenaMessage::$refData[$parent];
            KunenaMessage::$refData[$parent] = $id;
            return $lastRef;
        }
        return -1;
    }
    
    public static function queryMessages($categories = array()) {
        $db = JFactory::getDbo();
        $categoryCondition = '';
        if (!empty ($categories)) {
            if (!is_array($categories)) {
                $categories = array($categories);
            }
            $categoryCondition = ' AND catid IN (' . implode(',', $categories) . ')';
        }
        
        $countQuery = 'SELECT count(id) FROM #__kunena_messages WHERE 1' . $categoryCondition;
        $db->setQuery($countQuery);
        $mesCount = $db->loadResult();
        
        if ($mesCount <= 0) {
            return array();
        }
        $step = 30;
        $offset = 0;
        
        $mesList = array();
        
        $query = 'SELECT id, userid, subject, KM.time AS postTime, parent, message'
                .' FROM #__kunena_messages KM, #__kunena_messages_text'
                .' WHERE id=mesid'
                . $categoryCondition;
        while ($offset < $mesCount) {
            $db->setQuery($query, $offset, $step);
            $res = $db->loadObjectList();
//            var_dump($res);
            foreach ($res as $obj) {
                $mes = new KunenaMessage();
                $mes->fromObject($obj);
                $mesList[] = $mes;
            }
            $offset += $step;
        }

        return $mesList;
    }
    
    function toXMLNode() {
        $node = new XMLNode('messages');
        $node->addAttr('id', $this->id);
        
        $header = new XMLNode('header');
        {
            // header preparing
            $dateTime = new XMLNode('datetime', $this->dateTime);
            $header->addChild($dateTime);
            $author = new XMLNode('author', $this->author);
            $header->addChild($author);
            $subject = new XMLNode('subject', $this->subject);
            $header->addChild($subject);
            if ($this->ref > 0) {
                $ref = new XMLNode('msgref');
                $ref->addAttr('id', $this->ref);
                $header->addChild($ref);
            }
        }
        $node->addChild($header);
        
        $body = new XMLNode('body');
        $node->addChild($body);
        $content = new XMLNode('content', $this->contents);
        $body->addChild($content);
        
        return $node;
        
        
    }
}
?>
