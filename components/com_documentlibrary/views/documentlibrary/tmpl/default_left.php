<?php
defined ('_JEXEC') or die ('Access denied');
?>

<?php 
    foreach ($this->subjectsclasses as $id => $subject) { 
        $subjectLink = 'index.php?option=com_documentlibrary&task=documentLibrary&subject=' . $id;
        if ($this->filter > 0) {
            $subjectLink .= '&filter=' . $this->filter;
        }
?>
<p>
    <a href="<?php echo $subjectLink; ?>" >+ <?php echo $subject['name']; ?></a>
</p>
    <?php if ($id == $this->selectedSubjectId) { ?>
    <?php 
    foreach ($subject['classes'] as $id => $class) { 
        if ($id != $this->selectedClassId) {
    ?>
<p>
    &nbsp;&nbsp;<a href="<?php echo $subjectLink; ?>&class=<?php echo $id; ?>" >- <?php echo $class; ?></a>
</p>
    <?php    
            } else { ?>
<p>
    &nbsp;&nbsp;<label>- <?php echo $class; ?></label>
</p>
<?php
            }
        }
    } else { ?>
<?php
    }
?>
<?php } ?>