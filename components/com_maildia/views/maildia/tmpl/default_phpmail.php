<?php
defined ('_JEXEC') or die();

$action_url = JRoute::_('index.php?option=com_maildia&mail=php');
?>
<form action='<?php echo $action_url; ?>' method='post'>
<fieldset>
	<legend>PHP Mail</legend>
	<dt>To:</dt>
	<dl><input type='text' name='to' value='<?php echo $this->to; ?>' size=100/></dl>
	
	<dt>Subject:</dt>
	<dl><input type='text' name='subject' value='<?php echo $this->subject; ?>' size=100/></dl>
	
	<dt>Message:</dt>
	<dl><input type='text' name='message' value='<?php echo $this->message; ?>' size=100/></dl>
	
	<dt><input type='submit' class='button' name='send' value='Send mail'/></dt>
</fieldset>
</form>