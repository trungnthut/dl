<?php
defined ('_JEXEC') or die ('Access denied');
?>

<?php 
    foreach ($this->subjectsclasses as $id => $subject) { 
        $subjectLink = 'index.php?option=com_documentlibrary&task=documentLibrary&subject=' . $id;
        if ($this->filter > 0) {
            $subjectLink .= '&filter=' . $this->filter;
        }
        $subjectStats = empty($this->documentStatsBySubject[$id]['total']) ? 0 : $this->documentStatsBySubject[$id]['total'];
?>
<p>
    <a href="<?php echo $subjectLink; ?>" >+ <?php echo $subject['name']; ?> (<?php echo $subjectStats; ?>)</a>
</p>
    <?php if ($id == $this->selectedSubjectId) { ?>
    <?php 
    $subject_id = $id;
    foreach ($subject['classes'] as $id => $class) { 
        $classStats = empty($this->documentStatsBySubject[$subject_id][$id]) ? 0 : $this->documentStatsBySubject[$subject_id][$id];
        if ($id != $this->selectedClassId) {
    ?>
<p>
    &nbsp;&nbsp;<a href="<?php echo $subjectLink; ?>&class=<?php echo $id; ?>" >- <?php echo $class; ?> (<?php echo $classStats; ?>)</a>
</p>
    <?php    
            } else { ?>
<p>
    &nbsp;&nbsp;<label>- <?php echo $class; ?> (<?php echo $classStats; ?>)</label>
</p>
<?php
            }
        }
    } else { ?>
<?php
    }
?>
<?php } ?>