<?php
defined ('_JEXEC') or die();

require_once dirname(__FILE__).DS.'helper.php'; // get helper files

$modHelper = new ModTopContributorHelper();
$data = $modHelper->queryData();

require JModuleHelper::getLayoutPath('mod_top_contributors');
?>
