<?php
defined ('_JEXEC') or die ('Access denied');
?>
<table>
	<tr>
		<td>
			<form name="frmSearch" method="post" action="<?php echo $searchURL?>">
				<input type='hidden' name="quick_keyword_type" value="1"/>
				<input type='text' name="quick_keyword"/>&nbsp;<input type="submit" name="search" value="<?php echo JText::_("MOD_SEARCH_DL");?>"/>
				<br>
			</form>
		</td>
	</tr>
	<tr>
		<td>
			<a href="<?php echo $advancedSearchURL;?>"><?php echo JText::_('MOD_SEARCH_DL_ADVANCED');?></a>
			<br>
		</td>
	<tr>
		<td>
			<form name="frmSearch2" method="post" action="<?php echo $openByNumberURL?>">
				<label><?php echo JText::_('MOD_SEARCH_DL_OPEN_DOCUMENT_BY_VERSION');?></label>
				<input type='text' name="document_number"/>&nbsp;<input type="submit" name="" value="<?php echo JText::_('MOD_SEARCH_DL_OPEN'); ?>">
				<br>
			</form>
		</td>
	</tr>
</table>