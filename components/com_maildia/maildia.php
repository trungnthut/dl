<?php
// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport ('joomla.application.component.controller');

// This one will need a file name controller.php in the same folder
$controller = JController::getInstance('MailDia');

// get the task user want
$controller->execute(JRequest::getCmd('task'));

// redirect, what does this mean ?
$controller->redirect();
?>