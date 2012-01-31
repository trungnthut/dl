<?php
defined ('_JEXEC') or die();
?>
<form method="POST">
<!--    <fieldset>-->
        <legend>Select categories to export</legend>
        <?php echo $this->loadTemplate('categories'); ?>
        
<!--    </fieldset>-->
    <input type="submit" name="export" value="Export"/>
</form>

<?php
    if (JRequest::getVar('export', '') == 'Export') {
        if (isset($this->forumNode)) {
?>

<textarea cols="150" rows="15"> <?php echo $this->forumNode->represent(); ?> </textarea>
<?php 
        }
    } 
?>

