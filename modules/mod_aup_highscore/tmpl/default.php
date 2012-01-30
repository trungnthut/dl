<?php
defined ('_JEXEC') or die();
$i = 0;
?>

<fieldset>
    <table>
        <?php
            foreach ($scoreList as $scoreInfo) {
                $i = $i + 1;
                $userInfo = JFactory::getUser($scoreInfo->userid);
                $userUrl = JRoute::_('index.php?option=com_users&view=profile&user_id=' . $scoreInfo->userid);
        ?>
        <tr>
            <td><?php echo $i; ?>.</td>
            <td><a href="<?php echo $userUrl; ?>"><?php echo $userInfo->username; ?></a></td>
            <td><?php echo $scoreInfo->points; ?></td>
        </tr>
        <?php } ?>
    </table>
    
</fieldset>

