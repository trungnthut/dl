<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.controller');
jimport('joomla.form.form');
jimport( 'joomla.user.helper' );

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

define ('USER_SCORE_UPLOAD_NEW', 'plgaup_documentlibrary_upload_new');
define ('USER_SCORE_UPLOAD_VERSION', 'plgaup_documentlibrary_upload_version');
define ('USER_SCORE_DOWNLOAD', 'plgaup_documentlibrary_download');
define ('USER_SCORE_DOCUMENT_COMMENT', 'plgaup_documentlirary_comment');

/**
 * DocumentLibraryController
 */
class DocumentLibraryController extends JController {
    private $uploadDir;
	private $adminGroups;
    
    function __construct($config = array()) {
        parent::__construct($config);
        $this->uploadDir = 'upload/';
		$this->adminGroups = array(7, 8);
    }
    
    // nothing ? some default action will be done
    // default task: display will load the view 'views/documentlibrary/view.html.php'
    function display() {
//        parent::display();
		$view = JRequest::getCmd('view');
		switch ($view) {
			case 'upload':
				$this->upload();
				return;
			case 'document':
				$this->document();
				return;
			case 'documentLibrary':
			case 'documentlibrary':
				$this->documentLibrary();
				return;
			case 'search':
				$this->search();
				return;
			case 'documentComments':
				$this->documentComments();
				return;
			case 'documentDownloads':
				$this->documentDownloads();
				return;
			case 'documentTree':
				$this->documentTree();
				return;
			case 'userContrib':
				$this->userContrib();
				return;
			case 'userDownloads':
				$this->userDownloads();
				return;
			case 'filter':
				$this->filter();
				return;
			case 'comment':
			    // FIXME: not good in the logicstic
				$this->comment();
				return;
			case 'download':
				// FIXME: this should be task only
				$this->download();
				return;
			case 'edit':
				$this->edit();
				return;
			// case 'openDocumentByNumber':
				// // FIXME: task only
				// $this->openDocumentByNumber();
				// return;
			default:
				$this->homepage();
				return;
		}
        parent::display();
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
		
		// var_dump($this->getModel());
		// var_dump($this->getModel('Document'));
		$documentId = JRequest::getInt('document');
		$documentInfo = &$this->getModel('Document')->getDocumentInfo($documentId);
		$canEdit = &$this->canEdit($documentInfo);
		$view->assignRef('documentInfo', $documentInfo);
		$view->assignRef('canEdit', $canEdit);
        
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
	
	private function validateUpload($obj) {
		$return = true; 
		$return = $return && $obj != null && $obj->uploader_id > 0 && $obj->subject_id > 0 && $obj->class_id > 0 && $obj->type_id > 0
				&& (isset($obj->lesson) ? is_int($obj->lesson) : true) && !empty($obj->title);
		return $return;
	}
    
    private function processUploadedFile() {
        if (isset($_FILES['documentFile'])) {
            $targetPath = $this->uploadDir;
			if (!file_exists($targetPath)) {
				mkdir($targetPath);
			}
            
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
                $dataObj->lesson = JRequest::getInt('lesson');
                $dataObj->title = JRequest::getVar('documentTitle');
                $dataObj->summary = JRequest::getVar('summary');
                $dataObj->question = JRequest::getVar('question');
                $dataObj->uploaded_time = date( 'Y-m-d H:i:s', $time);
                $dataObj->fileName = $_FILES['documentFile']['name'];
				
				if (!$this->validateUpload($dataObj)) {
					JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPLOAD_ERROR'));
                	return false;
				}
                
                $model = $this->getModel();
                $document_id = $model->insertDocument($dataObj);
				if ($dataObj->original_id > 0) {
					// new version
					$this->updateScore(USER_SCORE_UPLOAD_VERSION);
				} else {
					// new document
					$this->updateScore(USER_SCORE_UPLOAD_NEW);
				}
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
			{
				// update user score
				$documentModel = &$this->getModel('Document');
				$documentInfo = $documentModel->getDocumentInfo($document_id);
				if ($documentInfo->uploader_id != $user_id) {
					$this->updateScore(USER_SCORE_DOCUMENT_COMMENT);
				}
			}
        
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
    	// redirect to the library
    	$url = DocumentLibraryHelper::url('documentlibrary');
		$this->setRedirect($url);
		return;
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
        
        if ($document_id > 0) {
            $documentModel = & $this->getModel('Document');
            $fileInfo = $documentModel->getDocumentInfo($document_id);
            $fileName = $fileInfo->fileName;
            $unixTime = strtotime($fileInfo->uploaded_time);
            $storedFileName = $this->genUploadedFileName($fileInfo->uploader_id, $fileName, $unixTime);
            $filePath = $this->uploadDir . $storedFileName;
            if (is_file($filePath)) {
            	
				$user = JFactory::getUser();
				// to subtract user score 
				$downloadData = new stdClass();
				$downloadData->document_id = $document_id;
				$downloadData->user_id = $user->id;
				$downloadData->time = date( 'Y-m-d H:i:s', mktime());
        
				// $documentModel = & $this->getModel('Document');
				$documentModel->insertDownload($downloadData);
				if ($user->id != $fileInfo->uploader_id) {
					$this->updateScore(USER_SCORE_DOWNLOAD);
				}
				
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

	function edit() {
		$this->requireLogin();

        $documentModel = & $this->getModel('Document');     
		$documentId = JRequest::getInt('document');
		$documentInfo = &$documentModel->getDocumentInfo($documentId);
		$canEdit = &$this->canEdit($documentInfo);
		if (!$canEdit) {
			JError::raiseError('adsad');
			die("Access denied");
		}

		$this->processEdit();

        JRequest::setVar('view', JRequest::getCmd('view', 'edit'));
        $view = & $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
        
		$view->assignRef('documentInfo', $documentInfo);
		$view->assignRef('canEdit', $canEdit);
		
		$view->setModel($documentModel);
		
        $documentTypeModel =& $this->getModel('DocumentType');
        $view->setModel($documentTypeModel);
        
        $subjectModel = & $this->getModel('Subjects');
        $view->setModel($subjectModel);
        
        $classModel = & $this->getModel('Classes');
        $view->setModel($classModel);
        
        if ((int)JRequest::getVar('parent', 0) > 0) {

        }
        
        parent::display();
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

	function userContrib() {
		$this->requireLogin();
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
        $documentModel = & $this->getModel('Document');
        $view->setModel($documentModel);
		
		$documentTypeModel = & $this->getModel('DocumentType');
		$view->setModel($documentTypeModel);
		
		parent::display();
	}
	
	function userDownloads() {
		$this->requireLogin();
		
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
        $documentModel = & $this->getModel('Document');
        $view->setModel($documentModel);
		
		$documentTypeModel = & $this->getModel('DocumentType');
		$view->setModel($documentTypeModel);
		
		parent::display();
	}
	
	function filter() {
		//$this->requireLogin();
		JRequest::setVar('view', JRequest::getCmd('view', 'filter'));
		$view = $this->getView(JRequest::getVar('view'), 'html', 'DocumentLibraryView');
		
		$classModel = & $this->getModel('Classes');
		$view->setModel($classModel);
		
		$subjectModel = & $this->getModel('Subjects');
		$view->setModel($subjectModel);
		
		$documentTypeModel = & $this->getModel('DocumentType');
		$view->setModel($documentTypeModel);
		
		parent::display();
	}
	
	private function canEdit($documentInfo) {
		
		$user = JFactory::getUser();
		if (empty($user->id) || empty($documentInfo)) {
			return false;
		}
 		$user_groups = (JUserHelper::getUserGroups($user->id));
		$intersect = array_intersect($this->adminGroups, $user_groups);
		
		//admin group id = 7
		// super user group id = 8
		if ($user->id == $documentInfo->document_id || !empty($intersect)) {
			return true;
		}
		return false;
	}
	
	private function processEdit() {
		$submit = JRequest::getVar('submit', '');
		if (!empty($submit)) {
			$this->updateFileData();
		}
		
		return false;
	}
	
	private function updateFileData() {
		$dataObj = new stdClass();
		$dataObj->document_id = JRequest::getVar('document', 0);
		if ($dataObj->document_id <= 0) {
			JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPDATE_ERROR'));
			return false;
		}
		// $dataObj->uploader_id = $uploader_id;
		$dataObj->subject_id = JRequest::getVar('subject');
		$dataObj->class_id = JRequest::getVar('class');
		$dataObj->type_id = JRequest::getVar('documentType');
		{
			// process type
			$documentTypeModel = & $this->getModel('DocumentType');
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
                
		$dataObj->lesson = JRequest::getInt('lesson');
		$dataObj->title = JRequest::getVar('documentTitle');
		$dataObj->summary = JRequest::getVar('summary');
		$dataObj->question = JRequest::getVar('question');
				
		// if (!$this->validateUpload($dataObj)) {
			// JError::raiseWarning(150, JText::_('COM_DOCUMENT_LIBRARY_VIEW_UPDATE_ERROR'));
			// return false;
		// }
//                 
		$model = & $this->getModel('DocumentLibrary');
		$model->updateDocument($dataObj);
                // $link = JRoute::_('index.php?com=documentLibrary&task=document&document=' . $document_id);
		$link = $this->url('document', array('document' => $dataObj->document_id));
		$this->setRedirect($link);
		return true;
	}

	private function updateScore($func_name) {
		$api_AUP = JPATH_SITE.DS.'components'.DS.'com_alphauserpoints'.DS.'helper.php';
		if ( file_exists($api_AUP))
		{
    		require_once ($api_AUP);
    		AlphaUserPointsHelper::newpoints( $func_name );
		}
	}
}
?>
