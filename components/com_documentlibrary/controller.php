<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.controller');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

/**
 * DocumentLibraryController
 */
class DocumentLibraryController extends JController {
    private $uploadDir;
    
    function __construct($config = array()) {
        parent::__construct($config);
        $this->uploadDir = 'upload/';
    }
    
    // nothing ? some default action will be done
    // default task: display will load the view 'views/documentlibrary/view.html.php'
    function display() {
//        parent::display();
        $this->homepage();
    }
    
    function sayHello() {
        echo 'Hello to me';
    }
    
    function upload() {
    	$this->requireLogin();
        if ($this->processUploadedFile()) {
            echo "redirect to document view";
            return;
        }
        
        JRequest::setVar('view', JRequest::getCmd('view', 'upload'));
        $view = & $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
        
        $documentTypeModel =& $this->getModel('DocumentType');
        $view->setModel($documentTypeModel);
        
        $subjectModel = & $this->getModel('Subjects');
        $view->setModel($subjectModel);
        
        $classModel = & $this->getModel('Classes');
        $view->setModel($classModel);
        
        if ((int)JRequest::getVar('parent', 0) > 0) {
            $documentModel = & $this->getModel('Document');
            $view->setModel($documentModel);
        }
        
        parent::display();
    }
    
    function document() {
        JRequest::setVar('view', JRequest::getCmd('view', 'document'));
        $view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
        
        $classModel = & $this->getModel('Classes');
        $view->setModel($classModel);
        
        $subjectModel = & $this->getModel('Subjects');
        $view->setModel($subjectModel);
        
        $documentCommentsModel = & $this->getModel('DocumentComments');
        $view->setModel($documentCommentsModel);
        
        parent::display();
    }
    
    function documentLibrary() {
        JRequest::setVar('view', JRequest::getCmd('view', 'documentLibrary'));
        $view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
        
        $subjectsClassesModel = & $this->getModel('SubjectsClasses');
        $view->setModel($subjectsClassesModel);
        
        $documentTypeModel = & $this->getModel('DocumentType');
        $view->setModel($documentTypeModel);
        
        $subjectModel = & $this->getModel('Subjects');
        $view->setModel($subjectModel);
        
        $classModel = & $this->getModel('Classes');
        $view->setModel($classModel);
        
        $documentModel = & $this->getModel('Document');
        $view->setModel($documentModel);
        
        parent::display();
    }
    
    private function processUploadedFile() {
        if (isset($_FILES['documentFile'])) {
            $targetPath = $this->uploadDir;
            mkdir($targetPath);
            
            $user = JFactory::getUser();
            $uploader_id = $user->id;
            $time = mktime();
            
            $targetFile = $targetPath . $this->genUploadedFileName($uploader_id, $_FILES['documentFile']['name'], $time);
            
            if (move_uploaded_file($_FILES['documentFile']['tmp_name'], $targetFile)) {
                $dataObj = new stdClass();
                $dataObj->document_id = null;
                $dataObj->parent_id = JRequest::getVar('parent', 0);
                $dataObj->original_id = JRequest::getVar('original', $dataObj->parent_id);
                if ($dataObj->original_id <= 0) {
                    $dataObj->original_id = $dataObj->parent_id;
                }
                $dataObj->uploader_id = $uploader_id;
                $dataObj->subject_id = JRequest::getVar('subject');
                $dataObj->class_id = JRequest::getVar('class');
                $dataObj->type_id = JRequest::getVar('documentType');
				{
					// process type
					$documentTypeModel = $this->getModel('DocumentType');
					$selectedType = $documentTypeModel->getTypeInfo($dataObj->type_id);
					if (empty($selectedType)) {
						JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_INVALID_TYPE'));
						return false;
					}
					if ($selectedType->extends) {
						$subtypes = JRequest::getVar('documentSubtypes');
						$dataObj->type_id = $subtypes[$dataObj->type_id];
					}
				}
                
                $documentModel = $this->getModel('Document');
                $dataObj->version = $documentModel->getNoVersions($dataObj->parent_id) + 1;
                $dataObj->lesson = JRequest::getVar('lesson');
                $dataObj->title = JRequest::getVar('documentTitle');
                $dataObj->summary = JRequest::getVar('summary');
                $dataObj->question = JRequest::getVar('question');
                $dataObj->uploaded_time = date( 'Y-m-d H:i:s', $time);
                $dataObj->fileName = $_FILES['documentFile']['name'];
                
                $model = $this->getModel();
                $document_id = $model->insertDocument($dataObj);
                // $link = JRoute::_('index.php?com=documentLibrary&task=document&document=' . $document_id);
                $link = $this->url('document', array('document' => $document_id));
                $this->setRedirect($link);
                return true;
            } else {
                JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_ERROR'));
                return false;
            }
        }
        return false;
    }
    
    private function genUploadedFileName($uploader_id = 0, $name = '', $time = '') {
        $str = $uploader_id . $name . $time;
        $fileName = md5($str);
        return $fileName;
    }
    
    function comment() {
        $document_id = JRequest::getVar('document', 0);
		{
			$returnURI = $this->url('document', array('document' => $document_id));
			if ($this->requireLogin($returnURI)) {
				return;
			}
		}
        $user = JFactory::getUser();
        $user_id = $user->id;
        $comment = JRequest::getVar('comment');
		
        $time = mktime();
        if ($document_id > 0 && $user_id > 0 && !empty ($comment) ) {
            $dataObj = new stdClass();
            $dataObj->poster_id = $user_id;
            $dataObj->document_id = $document_id;
            $dataObj->original_id = 0;
            $dataObj->time = date( 'Y-m-d H:i:s', $time);
            $dataObj->title = '';
            $dataObj->contents = $comment;
        
            $model = $this->getModel('DocumentComments');
            $model->insertComment($dataObj);
        }
        
        $url = '';
        if ($document_id > 0) {
            // $url = JRoute::_('index.php?com=documentLibrary&task=document&document=' . $document_id);
            $url = $this->url('document', array('document' => $document_id));
        } else {
            // $url = JRoute::_('index.php?com=documentLibrary');
            $url = $this->url();
            JError::raiseWarning(150, JTEXT::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_ERROR_INVALID_DOCUMENT'));
        }
        $this->setRedirect($url);
    }
    
    function homepage() {
        JRequest::setVar('view', JRequest::getCmd('view', 'homepage'));
        $view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
        
        $documentLibraryModel = & $this->getModel('DocumentLibrary');
        $view->setModel($documentLibraryModel);
		
        parent::display();
    }
    
    function download() {
    	$document_id = JRequest::getVar('document', 0);
		{
			$returnURI = $this->url('download', array('document' => $document_id));
			if ($this->requireLogin($returnURI)) {
				return;
			}
		}
        
        $user = JFactory::getUser();
        // to subtract user score 
        $downloadData = new stdClass();
        $downloadData->document_id = $document_id;
        $downloadData->user_id = $user->id;
        $downloadData->time = date( 'Y-m-d H:i:s', mktime());
        
        $documentModel = $this->getModel('Document');
        $documentModel->insertDownload($downloadData);

        if ($document_id > 0) {
            $documentModel = & $this->getModel('Document');
            $fileInfo = $documentModel->getDocumentInfo($document_id);
            $fileName = $fileInfo->fileName;
            $unixTime = strtotime($fileInfo->uploaded_time);
            $storedFileName = $this->genUploadedFileName($fileInfo->uploader_id, $fileName, $unixTime);
            $filePath = $this->uploadDir . $storedFileName;
            if (is_file($filePath)) {
                $fileSize = filesize($filePath);
                $mimeType = $this->mimeType($fileName);
                        
                header('Content-type: ' . $mimeType);
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                header('Content-Length: ' . $fileSize);
//                header('Cache-control: private');
                
                readfile($filePath);
				// $url = $this->url('document', array('document' => $document_id));
				// $this->setRedirect($url);
                exit();
            } else {
                JError::raiseWarning(150, JTEXT::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_ERROR_DOWNLOAD_FILE_CORRUPTED'));
                // $url = JRoute::_('index.php?com=documentLibrary&task=document&document=' . $document_id);
                $url = $this->url('document', array('document' => $document_id));
                $this->setRedirect($url);
            }
        } else {
            // $url = JRoute::_('index.php?com=documentLibrary');
            $url = $this->url();
            JError::raiseWarning(150, JTEXT::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_ERROR_INVALID_DOCUMENT'));
			$this->setRedirect($url);
        }
    }
    
    private function mimeType($fileName) {
        $fileInfo = pathinfo($fileName);
        $ext = $fileInfo['extension'];
        switch ($ext) {
            case 'pdf':
                return 'application/pdf';
            default:
                return 'application/octet-stream';
        }
        return 'application/octet-stream';
    }
	
	private function url($task = '', $otherOptions = null, $component = 'com_documentlibrary') {
		return DocumentLibraryHelper::url($task, $otherOptions, $component);
	}
	
	private function requireLogin($returnURI = '') {
		$currentUser = JFactory::getUser();
		
		if (empty($currentUser) || !$currentUser->id || $currentUser->id <= 0) {
			if (empty($returnURI)) { 
				$returnURI = JRequest::getURI();
			}
			$returnURI = base64_encode($returnURI);
		
			$loginURI = $this->url('', array('view' => 'login', 'return' => $returnURI ), 'com_users');
			$this->setRedirect($loginURI);
			return true;
		}
		return false;
	}

	function search() {
		JRequest::setVar('view', JRequest::getCmd('view', 'search'));
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
		$classModel = & $this->getModel('Classes');
		$view->setModel($classModel);
		
		$subjectModel = & $this->getModel('Subjects');
		$view->setModel($subjectModel);
		
		$documentTypeModel = & $this->getModel('DocumentType');
		$view->setModel($documentTypeModel);
		
		$search = JRequest::getVar('search', null);
		if (!empty($search)) {
			$documentLibraryModel = & $this->getModel('DocumentLibrary');
			$view->setModel($documentLibraryModel);
			
			$documentModel = & $this->getModel('Document');
			$view->setModel($documentModel);
		}
		
		parent::display();
	}
	
	function documentComments() {
		JRequest::setVar('view', JRequest::getCmd('view', 'documentComments'));
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
		$documentModel = & $this->getModel('Document');
		$view->setModel($documentModel);
		
		parent::display();
	}

	function documentDownloads() {
		JRequest::setVar('view', JRequest::getCmd('view', 'documentDownloads'));
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
		$documentModel = & $this->getModel('Document');
		$view->setModel($documentModel);
		
		parent::display();
	}
	
	function documentTree() {
		JRequest::setVar('view', JRequest::getCmd('view', 'documentTree'));
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
		$documentModel = & $this->getModel('Document');
		$view->setModel($documentModel);
		
		parent::display();
	}
	
	function openDocumentByNumber() {
		$number = JRequest::getVar('document_number', '');
		$number_info = explode('.', $number);
		$optionArr = array();
		if (count($number_info) != 2) {
			JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_INVALID_DOCUMENT_NUMBER'));		
		} else {
			$documentModel = $this->getModel('Document');
			$document_id = $documentModel->getDocumentIdFromNumber($number_info[0], $number_info[1]);
			$optionArr['document'] =  $document_id;
		}

		$url = DocumentLibraryHelper::url('document', $optionArr);
		$this->setRedirect($url);
	}
}
?>
