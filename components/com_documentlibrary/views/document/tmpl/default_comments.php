<?php
defined ('_JEXEC') or die ('Access denied');
?>

<?php foreach ($this->comments as $comment) { ?>
<div style='border: 1px solid lightgray; width: 45em; border-radius: 0.7em; margin-bottom: 1.5em'>
<p style='padding-left: 1.5em'>
    <label>
        <font size='2'>
            <?php echo uiText('COMMENT_POSTER'); ?>: <?php echo $comment->name; ?>
            &nbsp;&nbsp;<i><?php echo $comment->time; ?></i>
        </font>
    </label>
</p>
<p style='padding-left: 1.5em; padding-right: 1.5em'>
    <i>"<?php echo $comment->contents; ?>"</i>
</p>
</div>
<?php } ?>


