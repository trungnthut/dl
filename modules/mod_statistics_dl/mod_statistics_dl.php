<?php
defined('_JEXEC') or die; // no direct access allowed
 
require_once dirname(__FILE__).DS.'helper.php'; // get helper files

$modStatisticsDlHelper = new ModStatisticsDlHelper();

// get statistics
$totalMembers = $modStatisticsDlHelper->getTotalUser()->total;
$totalDocuments = $modStatisticsDlHelper->getTotalDocument()->total;
$totalLogins = $modStatisticsDlHelper->getTotalLogin()->total;
$totalUserOnlines = $modStatisticsDlHelper->getTotalUserOnline()->total;
$totalGuests = $modStatisticsDlHelper->getTotalGuest()->total;
$totalComments = $modStatisticsDlHelper->getTotalComment()->total;
$totalDownloads = $modStatisticsDlHelper->getTotalDownload()->total;

require JModuleHelper::getLayoutPath('mod_statistics_dl');
?>