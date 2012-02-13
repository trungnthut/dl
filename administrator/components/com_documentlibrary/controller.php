<?php
/**
* @version $Id: controller.php 21097 2011-04-07 15:38:03Z dextercowley $
* @copyright Copyright (C) 2005 - 2011 Open Source Matters, Inc. All rights reserved.
* @license GNU General Public License version 2 or later; see LICENSE.txt
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

/**
* Component Controller
*
* @package Joomla.Administrator
* @subpackage com_documentlibrary
*/
class DocumentlibraryController extends JController
{
/**
* @var string The default view.
* @since 1.6
*/
protected $default_view = 'documentlibrary';

/**
* Method to display a view.
*
* @param boolean If true, the view output will be cached
* @param array An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
*
* @return JController This object to support chaining.
* @since 1.5
*/

public function display($cachable = false, $urlparams = false)
{
// set default view if not set
JRequest::setVar('view', JRequest::getCmd('view', 'Documentlibrary'));
static $languageLoaded = false;
if (!$languageLoaded) {
	$language = JFactory::getLanguage();
	$extension = 'com_documentlibrary';
	$base_dir = JPATH_SITE . '\components\com_documentlibrary';
	$language_tag = $language->getTag(); // loads the current language-tag
	$language->load($extension, $base_dir, $language_tag, true);
	$languageLoaded = true;
}
// call parent behavior
parent::display($cachable);
}
}