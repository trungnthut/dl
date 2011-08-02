<?php
defined ('_JEXEC') or die ('Access denied');

include_once JPATH_COMPONENT.DS.'helpers'.DS.'documentlibrary.php';

function showTree($node, $currentDocument) {
	if (empty($node)) {
		return '';
	}
	
	return drawNode($node, $currentDocument);
}

function drawNode($node, $currentDocument, $lvl = 0) {
	$i = 0;
	$out = '';
	$line = '';
	while ($i < $lvl - 1) {
		$line .= '&nbsp; &nbsp; &nbsp; |';
		$i++;
	}
	
	if ($lvl > 0) {
		$out .= $line . '&nbsp; &nbsp; &nbsp; |<br/>';;
		$out .= $line . '&nbsp; &nbsp; &nbsp; |---';
	} else {
		$out .= '&nbsp; &nbsp;';
	}
	
	$out .= singleNode($node, $currentDocument) . "\n<br/>\n";
	
	$nextLvl = $lvl + 1;
	if (!empty($node->children)) {
		foreach ($node->children as $childNode) {
			$out .= drawNode($childNode, $currentDocument, $nextLvl);
		}
	}
	
	return $out;
}

function singleNode($node, $currentDocument) {
	$url = DocumentLibraryHelper::url('document', array('document' => $node->id));
	$class = $currentDocument == $node->id ? 'currentNode' : 'otherNode';
	$style = $currentDocument == $node->id ? 'background-color:yellow; border: 1px solid red' : '';
	$astyle = 'text-decoration: none';
	$ret = '';
	$ret .= "<span class='$class' style='$style'>";
	$ret .= "<a href='{$url}' style='$astyle'>" . $node->version . '</a>';
	$ret .= '</span>';
	return $ret;
}
?>

<?php 
if (!empty($this->tree)) {
	echo showTree($this->tree, $this->document);
}
?>
