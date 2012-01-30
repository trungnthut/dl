<?php
defined ('_JEXEC') or die();

require_once dirname(__FILE__).DS.'helper.php'; // get helper files

$aupHelper = new ModAupHighScoreHelper();
$scoreList = $aupHelper->queryScore();

require JModuleHelper::getLayoutPath('mod_aup_highscore');
?>
