<?php
defined ('_JEXEC') or die;

$language =& JFactory::getLanguage();
$extension = 'mod_documentlibrary';
$base_dir = JPATH_SITE . '/components/com_documentlibrary';
$language_tag = $language->getTag(); // loads the current language-tag
$language->load($extension, $base_dir, $language_tag, true);

$contribUrl = JRoute::_('index.php?option=com_documentlibrary&view=userContrib&user_id=' . $this->data->id);
$downloadsUrl = JRoute::_('index.php?option=com_documentlibrary&view=userDownloads&user_id=' . $this->data->id);
?>

<fieldset>
	<legend><?php echo JText::_('USER_PROFILE_DIARY_TITLE');?></legend>
	<dl>
		<dt><a href='<?php echo $contribUrl; ?>'><?php echo JText::_('USER_PROFILE_DIARY_CONTRIB'); ?></a></dt>
		<dt><a href='<?php echo $downloadsUrl; ?>'><?php echo JText::_('USER_PROFILE_DIARY_DOWNLOADS'); ?></a></dt>
	</dl>
</fieldset>