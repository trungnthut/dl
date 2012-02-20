<?php

defined('_JEXEC') or die();

?>
<fieldset>
    <legend>Statistics</legend>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=userstats')?>">
                User statistics
            </a>
        </p>
    </dt>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=statistics')?>">
                New document upload statistics
            </a>
        </p>
    </dt>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=versionuploadstats')?>">
                New version upload statistics
            </a>
        </p>
    </dt>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=downloadstats')?>">
                Document comment and download statistics
            </a>
        </p>
    </dt>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=subjectstats')?>">
                Documents upload statistics by subjects
            </a>
        </p>
    </dt>
    <dt>
        <p>
            <a href="<?php echo JRoute::_('index.php?option=com_documentlibrary&view=usersubjectuploadstats')?>">
                User upload statistics by subjects
            </a>
        </p>
    </dt>
</fieldset>

