<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

jimport('joomla.application.component.controller');
include 'Mail/Mail.php';

/**
 * MailDiaController
 */
class MailDiaController extends JController {
	function display() {
		$mailType = JRequest::getVar('mail');

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
		
		$result = mail($to, $subject, $message);

		$info = 'Send to: ' . $to . ";\n Subject: " . $subject . ";\n Message: " . $message;
		if ($result) {
			$info = "Ok !\n" . $info;
		} else {
			$info = "Error !\n" . $info;
		}

 		JError::raiseNotice(150, $info);
	}
	
	function smtpmail() {
		$to = JRequest::getString('to');
		$subject = JRequest::getString('subject');
		$message = JRequest::getString('message');
		
		$server = JRequest::getString('server');
		$auth = JRequest::getVar('auth');
		$port = JRequest::getInt('port');
		$username = JRequest::getString('username');
		$password = JRequest::getString('password');
		
		$header = array(
			'From' => $username,
			'To' => $to,
			'Subject' => $subject
		);
		
		$smtp = Mail::factory('smtp',
			array(
				'host' => $server,
				'auth' => true,
				'username' => $username,
				'password' => $password
			)
		);
		
		$mail = $smtp->send($to, $header, $message);
		
		if (PEAR::isError($mail)) {
			JError::raiseError(150, $mail->getMessage());
		} else {
			JError::raiseNotice(150, 'SMTP OK !');
		}
	}
}

?>