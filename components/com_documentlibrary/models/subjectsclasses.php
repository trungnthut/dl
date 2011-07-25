<?php
defined ('_JEXEC') or die('Access denied');

jimport ('joomla.application.component.modelitem');

define('MIN_SUBJECT_ID', 0);
define('MIN_CLASS_ID', 0);

class DocumentLibraryModelSubjectsClasses extends JModelItem {
    private $subjectModel;
    private $classModel;
    private $subjects;
    private $classes;
    
    function __construct($config = array()) {
        parent::__construct($config);
        
        require_once 'subjects.php';
        $this->subjectModel = new DocumentLibraryModelSubjects();
        
        require_once 'classes.php';
        $this->classModel = new DocumentLibraryModelClasses();
        
        $this->subjects = $this->subjectModel->getSubjectList();
        $this->classes = $this->classModel->getClassList();
    }
    
    function getClassesForSubject($subject_id = -1) {
        if ($subject_id < MIN_SUBJECT_ID) {
            return null;
        }
        
        return $this->classes;
    }
    
    function getSubjectsClasses() {        
        $ret = array();
        foreach ($this->subjects as $id => $name) {
            $entry = array(
                'name' => $name,
                'classes' => $this->classes
            );
            
            $ret[$id] = $entry;
        }
        
        return $ret;
    }
}

?>
