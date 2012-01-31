<?php
defined ('_JEXEC') or die();
$i = 0;
?>

<table width="100%">
    <?php
    foreach ($data as $contributor) {
        $i = $i + 1;
        $userInfo = JFactory::getUser($contributor->uploader_id);
        $userUrl = JRoute::_('index.php?option=com_users&view=profile&user_id=' . $contributor->uploader_id);
        $contribUrl = JRoute::_('index.php?option=com_documentlibrary&view=userContrib&user_id=' . $contributor->uploader_id);
        ?>
        <tr>
            <td><?php echo $i; ?>.</td>
            <td><a href="<?php echo $userUrl; ?>"><?php echo $userInfo->username; ?></a></td>
            <td><a href="<?php echo $contribUrl; ?>"><?php echo $contributor->noDocs; ?></a></td>
        </tr>
    <?php } ?>
</table>