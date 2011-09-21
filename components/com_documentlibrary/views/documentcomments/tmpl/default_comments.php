<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';
DocumentLibraryHelper::setUiTextPrefix('COM_DOCUMENT_LIBRARY_VIEW_DOCUMENT_COMMENTS_');

?>

<?php foreach ($this->comments as $comment) { ?>
<?php
	$documentUrl = DocumentLibraryHelper::url('document', array('document' => $comment->document_id));
	// $documentNumber = DocumentLibraryHelper::documentNumber($comment->original_id, $comment->version, $comment->document_id);
	$documentNumber = $comment->version;
?>
<div style='border: 1px solid lightgray; width: 99%; border-radius: 0.7em; margin-bottom: 1.5em; margin-left: 3px'>
<p style='padding-left: 1.5em'>
    <label>
        <font size='2'>
            <?php echo DocumentLibraryHelper::uiText('COMMENT_POSTER'); ?>: <a href='<?php echo DocumentLibraryHelper::profile($comment->poster_id); ?>'><?php echo $comment->name; ?></a>
            &nbsp;&nbsp;<i><?php echo $comment->time; ?></i>
            <?php if (isset($this->viewAll)) { ?>
            	&nbsp;&nbsp;<i>(<?php echo DocumentLibraryHelper::uiText('VERSION') ?>: <a href='<?php echo $documentUrl?>'><?php echo $documentNumber; ?></a>)</i>
            <?php	} ?>
        </font>
    </label>
</p>
<p style='padding-left: 1.5em; padding-right: 1.5em'>
    <i>"<?php echo str_replace( "\n", "<br/>", $comment->contents); ?>"</i>
</p>
</div>
<?php } ?>