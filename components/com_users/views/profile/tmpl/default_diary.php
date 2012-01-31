<?php
defined('_JEXEC') or die;

$language = & JFactory::getLanguage();
$extension = 'mod_documentlibrary';
$base_dir = JPATH_SITE . '/components/com_documentlibrary';
$language_tag = $language->getTag(); // loads the current language-tag
$language->load($extension, $base_dir, $language_tag, true);

$contribUrl = JRoute::_('index.php?option=com_documentlibrary&view=userContrib&user_id=' . $this->data->id);
$downloadsUrl = JRoute::_('index.php?option=com_documentlibrary&view=userDownloads&user_id=' . $this->data->id);

// get user points
$userPoints = 0;
$refererId = ""; 
{
    $db = JFactory::getDbo();
    $query = 'SELECT referreid, points FROM #__alpha_userpoints WHERE '
            . ' userid = ' . $this->data->id;
    $db->setQuery($query);
    $res = $db->loadObject();
    if (!empty ($res)) {
        $refererId = $res->referreid;
        $userPoints = $res->points;
    }
}
if (!empty($refererId)) {
    $scoreUrl = JRoute::_('index.php?option=com_alphauserpoints&view=account&userid=' . $refererId);
}
?>

<fieldset>
    <legend><?php echo JText::_('USER_PROFILE_DIARY_TITLE'); ?></legend>
    <dl>
        <dt><a href='<?php echo $contribUrl; ?>'><?php echo JText::_('USER_PROFILE_DIARY_CONTRIB'); ?></a></dt>
        <dt><a href='<?php echo $downloadsUrl; ?>'><?php echo JText::_('USER_PROFILE_DIARY_DOWNLOADS'); ?></a></dt>
        <dt><?php echo JTEXT::_('USER_PROFILE_DIARY_SCORE'); ?>
        <?php if (!empty($scoreUrl)) { ?>
            <a href='<?php echo $scoreUrl; ?>'>
        <?php } ?>
            <?php echo $userPoints; ?>
        <?php if (!empty($scoreUrl)) { ?>
            </a>
        <?php } ?>
        </dt>
    </dl>
</fieldset>