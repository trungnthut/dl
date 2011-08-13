<?php
defined ('_JEXEC') or die ('Access denied');

$post_url = JRoute::_('index.php?option=com_documentlibrary&task=comment');
?>
<form action='<?php echo $post_url?>' method='POST'>
    <p>
        <label><?php echo uiText('LABEL_POST_COMMENT'); ?></label>
    </p>
    <p>
        <textarea name='comment' style='width: 99%; height: 7em; border: 1px solid #CCCCCC; margin-left: 2px'></textarea>
    </p>
    <p>
        <input type='hidden' name='document' value='<?php echo $this->documentId?>'/>
        <input type='submit' class='button' name='submit' value='<?php echo uiText('POST_COMMENT'); ?>'></input>
    </p>
</form>
