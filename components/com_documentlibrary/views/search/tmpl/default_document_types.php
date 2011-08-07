<?php
defined('_JEXEC') or die ('Access denied');
$even = true;
?>

<?php foreach ($this->documentTypes as $type) { ?>
	<?php 
		$even = !$even;
		$id = $type->type_id;
	?>
	<?php if (!$even) { ?>
		<p style='clear: left'>
	<?php } ?>
		<div style='width: 15em; display: block; float: left'>
			<input type='checkbox' name='documentTypes[<?php echo $id; ?>]' value='<?php echo $id; ?>' <?php echo $this->selectedTypes[$id] == $id ? 'checked' : ''; ?>/>
			<label><?php echo $type->name; ?></label>
		</div>
	<?php if ($even) { ?>
		</p>
	<?php } ?>
<?php } ?>
<br style='clear: left'/>
