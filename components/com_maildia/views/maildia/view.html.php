<?php
// no direct access
defined ('_JEXEC') or die ('Restricted access');

// import joomla view library
jimport('joomla.application.component.view');

class MailDiaViewMailDia extends JView {
	function display($tpl = null) {
		$this->to = JRequest::getString('to', 'trungtin1k48@yahoo.com');
		$this->subject = JRequest::getString('subject', 'Mail subject');
		$this->message = JRequest::getString('message', 'a message');
		
		$this->server = JRequest::getString('server', 'smtp.googlemail.com');
		$this->auth = JRequest::getVar('auth', 'true'); // ?
		$this->secure = JRequest::getVar('secure', 'ssl');
		$this->port = JRequest::getInt('port', 465);
		
		$this->username = JRequest::getString('username', 'trungnthut@gmail.com');
		$this->password = JRequest::getString('password', '');
		parent::display($tpl);
	}
}
?>