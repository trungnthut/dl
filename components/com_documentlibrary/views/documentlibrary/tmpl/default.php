<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1><?php echo $this->msg; ?></h1>

<table>
    <tr>
        <td rowspan="2">
            <?php echo $this->loadTemplate('left');?>
        </td>
        <td>
            <?php echo $this->loadTemplate('top'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $this->loadTemplate('center'); ?>
        </td>
    </tr>
</table>


