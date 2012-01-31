<?php
defined ('_JEXEC') or die();

function calculateMaxLevel($categories, $maxEntries = 20) {
    $maxLvl = 0;
    $noEntries = 1;
    $entriesToConsiderNext = array($categories);
    while ($noEntries <= $maxEntries) {
        $thisLvlCount = 0;
        $nextConsiderLvl = array();
        foreach ($entriesToConsiderNext as $entry) {
            $thisLvlCount += count($entry->children());
            $nextConsiderLvl = array_merge($nextConsiderLvl, $entry->children());
        }
        $noEntries += $thisLvlCount;
        if ($noEntries <= $maxEntries) {
            $entriesToConsiderNext = $nextConsiderLvl;
            $maxLvl++;
        }
        if ($thisLvlCount == 0) {
            break;
        }
    }
    return $maxLvl;
}

function printCat($category, $maxLvl, $level = 0) {
    $categoriesToSelect = array();
    if ($level > $maxLvl) {
        return array();
    }
    $levelStr = "";
    $i=0;
    while ($i<$level) {
        $levelStr .= '-';
        $i++;
    }
    $postData = JRequest::getVar('categories', array());
    $export = JRequest::getVar('export', '');
    $isPost = $export != '';
    foreach ($category->children() as $child) {
        $categoriesToSelect[] = $child->id();
        $checked = $isPost ? (isset ($postData[$child->id()]) ? 'checked' : '') : 'checked';
        echo '<input type="checkbox" name="categories[' . $child->id() . ']" value="' . $child->id() . '"' . $checked . '/>';
        echo '<label> ' . $levelStr . ' ' . $child->name() . '</label>';
        echo '<br/>';
        if (count($child->children()) > 0) {
            $subCategories = printCat($child, $maxLvl, $level + 1);
            $categoriesToSelect = array_merge($categoriesToSelect, $subCategories);
        }
    }
    return $categoriesToSelect;
}
//foreach ($this->categories->children() as $child) { 
//    printCat($child);
//}
$maxLvl = calculateMaxLevel($this->categories, 24);
$categoriesToSelect = printCat($this->categories, $maxLvl);
$categoriesToSelect = array_unique($categoriesToSelect);
?>
<input type="hidden" name="categoriesToSelect" value="<?php echo implode(',', $categoriesToSelect); ?>"/>
