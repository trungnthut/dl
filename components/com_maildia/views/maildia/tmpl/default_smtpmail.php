<?php
defined ('_JEXEC') or die();
$action_url = JRoute::_('index.php?option=com_maildia&mail=smtp');
?>
<form name='smpt' action='<?php echo $action_url; ?>' method='post'>
<fieldset>
	<legend>SMTP Mail</legend>
	<table width="100%">
		<tr>
			<td width="50%">
	<fieldset>
		<legend>Send Info</legend>
	<dt>To:</dt>
	<dl><input type='text' name='to' value='<?php echo $this->to; ?>' size=50/></dl>
	
	<dt>Subject:</dt>
	<dl><input type='text' name='subject' value='<?php echo $this->subject; ?>' size=50/></dl>
	
	<dt>Message:</dt>
	<dl><input type='text' name='message' value='<?php echo $this->message; ?>' size=50/></dl>
	</fieldset>
	</td>
	
	<td>
	
	<fieldset>
		<legend>SMTP Info</legend>
		<dt>Server:</dt>
		<dl><input type='text' name='server' value='<?php echo $this->server; ?>' size=50/></dl>
		
		<dt>Auth:</dt>
		<dl><input type='text' name='auth' value='<?php echo $this->auth; ?>' size=50/></dl>
		
		<dt>Port:</dt>
		<dl><input type='text' name='port' value='<?php echo $this->port; ?>' size=50/></dl>
		
		<dt>Username:</dt>
		<dl><input type='text' name='username' value='<?php echo $this->username; ?>' size=50/></dl>
		
		<dt>Password:</dt>
		<dl><input type='password' name='password' value='<?php echo $this->password; ?>' size=50/></dl>
	</fieldset>
	</td>
	</tr>
	</table>
	
	<dt><input type='submit' class='button' name='send' value='Send mail'/></dt>
</fieldset>
</form>