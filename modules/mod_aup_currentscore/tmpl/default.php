<?php
defined ('_JEXEC') or die();
$scoreUrl = JRoute::_('index.php?option=com_alphauserpoints&view=account&userid=' . $scoreInfo->referreid);
?>
<a href="<?php echo $scoreUrl; ?>"><h2><?php echo $scoreInfo->points; ?></h2></a>

