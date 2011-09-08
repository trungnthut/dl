<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.controller');

/**
 * MailDiaController
 */
class MailDiaController extends JController {
	function display() {
		$mailType = JRequest::getVar('mail');
		var_dump($_POST);

		switch ($mailType) {
			case 'php':
				$this->phpmail();
				break;
			case 'smtp':
				$this->smtpmail();
				break;
		}

		parent::display();
	}
	
	function phpmail() {
		$to = JRequest::getString('to');
		$subject = JRequest::getString('subject');
		$message = JRequest::getString('message');
		
		// $result = mail($to, $subject, $message);
		$mailer = JFactory::getMailer();
		$mailer->setSender('testing@giaovien.phutho.vn');
		$mailer->addRecipient($to);
		$mailer->setSubject($subject);
		$mailer->setBody($message);
		$mailer->useSendmail();
		
		$result = $mailer->Send();
		var_dump($result);
		
		if ($result == false) {
			JError::raiseError(100, "Error !");
		} else {
			JError::raiseNotice(99, "ok");
		}

		// $info = 'Send to: ' . $to . ";\n Subject: " . $subject . ";\n Message: " . $message;
		// if ($result) {
			// $info = "Ok !\n" . $info;
		// } else {
			// $info = "Error !\n" . $info;
		// }

 		// JError::raiseNotice(150, $info);
	}
	
	function smtpmail() {
		$to = JRequest::getString('to');
		$subject = JRequest::getString('subject');
		$message = JRequest::getString('message');
		
		$server = JRequest::getString('server');
		$auth = JRequest::getVar('auth');
		$secure = JRequest::getString('secure');
		$port = JRequest::getInt('port');
		$username = JRequest::getString('username');
		$password = JRequest::getString('password');
		
		$mailer = JFactory::getMailer();
		$mailer->setSender($username);
		$mailer->addRecipient($to);
		$mailer->setSubject($subject);
		$mailer->setBody($message);
		$mailer->useSMTP($auth, $server, $username, $password, $secure, $port);
		
		$result = $mailer->Send();
		
		if ($result == false) {
			JError::raiseError(100, "Error !");
		} else {
			JError::raiseNotice(99, "ok");
		}
	}
}

?>