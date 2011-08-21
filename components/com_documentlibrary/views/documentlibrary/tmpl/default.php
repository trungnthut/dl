<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<h1><?php echo $this->msg; ?></h1>

<form method="POST" action="<?php echo JRequest::getURI(); ?>">
<table style='border: 1px solid #CCCCCC'>
    <tr style='border: 1px solid #CCCCCC'>
        <td rowspan="2" style='border: 1px solid #CCCCCC'>
            <?php echo $this->loadTemplate('left');?>
        </td>
        <td style='border: 1px solid #CCCCCC'>
            <?php echo $this->loadTemplate('top'); ?>
        </td>
    </tr>
    <tr style='border: 1px solid #CCCCCC'>
        <td style='border: 1px solid #CCCCCC; vertical-align:top;'>
            <?php echo $this->loadTemplate('document_list'); ?>
        </td>
    </tr>
</table>
</form>


