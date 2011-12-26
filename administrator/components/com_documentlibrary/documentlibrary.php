<?php
defined ("_JEXEC") or die();

jimport('joomla.application.component.controller');

$controller = JController::getInstance('DocumentLibrary');

$controller->execute(JRequest::getCmd('task'));

$controller->redirect();

?>
