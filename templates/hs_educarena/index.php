<?php

/**
 * Template for Joomla! CMS, created with Artisteer.
 * See readme.txt for more details on how to use the template.
 */

defined('_JEXEC') or die;

require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'functions.php';

// Create alias for $this object reference.
$document = & $this;

// Shortcut for template base url.
$templateUrl = $document->baseurl . '/templates/' . $document->template;

// Initialize version-specific view.
$view = $this->artx = ('1.6' == $GLOBALS['version']->RELEASE) ? new ArtxPage16($this) : new ArtxPage15($this);

// Decorate component with Artisteer style.
$view->componentWrapper();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $document->language; ?>" lang="<?php echo $document->language; ?>" >
<head>
 <jdoc:include type="head" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/system.css" type="text/css" />
 <link rel="stylesheet" href="<?php echo $document->baseurl; ?>/templates/system/css/general.css" type="text/css" />
 <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/template.css" media="screen" />
 <link rel="stylesheet" type="text/css" href="<?php echo $templateUrl; ?>/css/newfeeds.css"/>
 <!--[if IE 6]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie6.css" type="text/css" media="screen" /><![endif]-->
 <!--[if IE 7]><link rel="stylesheet" href="<?php echo $templateUrl; ?>/css/template.ie7.css" type="text/css" media="screen" /><![endif]-->
 <script type="text/javascript" src="<?php echo $templateUrl; ?>/script.js"></script>
</head>
<body class="<?php echo $view->bodyClass(); ?>">
    <div id="art-page-background-gradient"></div>
<div id="art-main">
<div class="art-sheet">
    <div class="art-sheet-tl"></div>
    <div class="art-sheet-tr"></div>
    <div class="art-sheet-bl"></div>
    <div class="art-sheet-br"></div>
    <div class="art-sheet-tc"></div>
    <div class="art-sheet-bc"></div>
    <div class="art-sheet-cl"></div>
    <div class="art-sheet-cr"></div>
    <div class="art-sheet-cc"></div>
    <div class="art-sheet-body">
<div class="art-header">
    <div class="art-header-png"></div>
    <div class="art-header-jpeg"></div>
    <img src='<?php echo $templateUrl; ?>/images/banner.gif' style='width:100%; height: 100%'/>
<div class="art-logo">
<!--  <h1 id="name-text" class="art-logo-name"><a href="<?php echo $document->baseurl; ?>/">Headline</a></h1> -->
<!--  <div id="slogan-text" class="art-logo-text">Slogan text</div> -->
</div>

</div>
<?php if ($view->containsModules('user3', 'extra1', 'extra2')) : ?>
<div class="art-nav">
	<div class="l"></div>
	<div class="r"></div>
	<?php if ($view->containsModules('extra1')) : ?>
	<div class="art-menu-extra1"><?php echo $view->position('extra1'); ?></div>
	<?php endif; ?>
	<?php if ($view->containsModules('extra2')) : ?>
	<div class="art-menu-extra2"><?php echo $view->position('extra2'); ?></div>
	<?php endif; ?>
	<?php echo $view->position('user3'); ?>
</div>
<?php endif; ?>
<?php echo $view->position('banner1', 'art-nostyle'); ?>
<?php echo $view->positions(array('top1' => 33, 'top2' => 33, 'top3' => 34), 'art-block'); ?>
<div class="art-content-layout">
    <div class="art-content-layout-row">
<?php if ($view->containsModules('left')) : ?>
<div class="art-layout-cell art-sidebar1">
<?php echo $view->position('left', 'art-block'); ?>

</div>
<?php endif; ?>
<div class="art-layout-cell art-<?php echo $view->contentCellClass(array('left' => 'sidebar1', 'content' => 'content', 'right' => 'sidebar2')); ?>">

<?php
  echo $view->position('banner2', 'art-nostyle');
  if ($view->containsModules('breadcrumb'))
    echo artxPost($view->position('breadcrumb'));
  echo $view->positions(array('user1' => 50, 'user2' => 50), 'art-article');
  echo $view->position('banner3', 'art-nostyle');
  if ($view->hasMessages())
    echo artxPost('<jdoc:include type="message" />');
  echo '<jdoc:include type="component" />';
  echo $view->position('banner4', 'art-nostyle');
  echo $view->positions(array('user4' => 50, 'user5' => 50), 'art-article');
  echo $view->position('banner5', 'art-nostyle');
?>

</div>
<?php if ($view->containsModules('right')) : ?>
<div class="art-layout-cell art-sidebar2">
<?php echo $view->position('right', 'art-block'); ?>

</div>
<?php endif; ?>

    </div>
</div>
<div class="cleared"></div>

<?php echo $view->positions(array('bottom1' => 33, 'bottom2' => 33, 'bottom3' => 34), 'art-block'); ?>
<?php echo $view->position('banner6', 'art-nostyle'); ?>
<div class="art-footer">
    <div class="art-footer-t"></div>
    <div class="art-footer-l"></div>
    <div class="art-footer-b"></div>
    <div class="art-footer-r"></div>
    <div class="art-footer-body">
         <?php echo $view->position('syndicate'); ?>
        <div class="art-footer-text">
  <?php if ($view->containsModules('copyright')): ?>
  <?php echo $view->position('copyright', 'art-nostyle'); ?>
  <?php else: ?>
    <?php ob_start(); ?>
<p>Copyright &copy; 2011 ---.<br />
All Rights Reserved.</p>

    <?php echo str_replace('%YEAR%', date('Y'), ob_get_clean()); ?>
  <?php endif; ?>
        </div>
        <div class="cleared"></div>
    </div>
</div>

		<div class="cleared"></div>
    </div>
</div>
<div class="cleared"></div>
<p class="art-page-footer">Designed by <a href="http://joomla16templates.blogspot.com">free joomla 1.6 templates</a>.</p>

</div>

<?php echo $view->position('debug'); ?>
</body>
</html>