<?php

/**
 * Overwrites default template of the content/featured component of Joomla 1.6.
 * Joomla 1.6 content/featured supplants Joomla 1.5 content/frontpage.
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . str_replace('/', DIRECTORY_SEPARATOR, '/../../../functions.php');

$view = new ArtxContent16($this, $this->params);

echo $view->beginPageContainer('blog-featured');
if ($view->showPageHeading)
    echo $view->pageHeading();
?>
<?php $leadingcount = 0; ?>
<?php if (!empty($this->lead_items)) : ?>
<div class="items-leading">
<?php foreach ($this->lead_items as &$item) : ?>
<div class="leading-<?php echo $leadingcount; ?><?php echo $item->state == 0 ? ' system-unpublished' : null; ?>">
<?php
	$this->item = &$item;
	echo $this->loadTemplate('item');
?>
</div>
<?php $leadingcount++; ?>
<?php endforeach; ?>
</div>
<?php endif; ?>
<?php
	$introcount = count($this->intro_items);
	$counter = 0;
?>
<?php if (!empty($this->intro_items)) : ?>
<?php foreach ($this->intro_items as $key => &$item) : ?>
<?php
	$key = ($key - $leadingcount) + 1;
	$rowcount = (((int)$key - 1) % (int)$this->columns) + 1;
	$row = $counter / $this->columns;
	if ($rowcount == 1) :
?>
<div class="items-row cols-<?php echo (int) $this->columns; ?> <?php echo 'row-' . $row; ?>">
<?php endif; ?>
<div class="item column-<?php echo $rowcount;?><?php echo $item->state == 0 ? ' system-unpublished"' : null; ?>">
<?php
	$this->item = &$item;
	echo $this->loadTemplate('item');
?>
</div>
<?php $counter++; ?>
<?php if ($rowcount == $this->columns || $counter == $introcount): ?>
<span class="row-separator"></span>
</div>
<?php endif; ?>
<?php endforeach; ?>
<?php endif; ?>
<?php if (!empty($this->link_items)) : ?>
<?php ob_start(); ?>
<div class="items-more">
<?php echo $this->loadTemplate('links'); ?>
</div>
<?php echo artxPost(ob_get_clean()); ?>
<?php endif; ?>
<?php if ($this->params->def('show_pagination', 2) == 1  || ($this->params->get('show_pagination') == 2 && $this->pagination->get('pages.total') > 1)) : ?>
<?php ob_start(); ?>
<div class="pagination">
<?php if ($this->params->def('show_pagination_results', 1)) : ?>
<p class="counter"><?php echo $this->pagination->getPagesCounter(); ?></p>
<?php endif; ?>
<?php echo $this->pagination->getPagesLinks(); ?>
</div>
<?php echo artxPost(ob_get_clean()); ?>
<?php endif; ?>
<?php echo $view->endPageContainer(); ?>