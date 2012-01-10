<?php
defined ('_JEXEC') or die();
$userSyncUrl = JRoute::_('index.php?option=com_dlaup&task=syncUsers');
$url = JRoute::_('index.php?option=com_dlaup&task=sync');
$testUrl = JRoute::_('index.php?option=com_dlaup&task=testSync');
?>

<form method='post' action='<?php echo $userSyncUrl; ?>'>
	<p>
	Ok, sync user data;
	</p>
	
	<p>
		<input type=submit value="sync users!"/>
	</p>
	
</form>

<form method='post' action='<?php echo $url; ?>'>
	<p>
	Ok, we gonna sync activities of document library to have point on alpha user points;
	</p>
	
	<p>
		<input type=submit value="sync it then!"/>
	</p>
	
</form>

<form method='post' action='<?php echo $testUrl; ?>'>
	<p>
	Ok, we gonna test the result when doing "sync";
	</p>
	
	<p>
		<input type=submit value="test it then!"/>
	</p>
	
</form>


