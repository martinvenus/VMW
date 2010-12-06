<?php //netteCache[01]000238a:3:{s:4:"time";s:21:"0.46519500 1291667639";s:6:"expire";i:1291667639;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:56:"/var/www/VMW/www/../app/templates/Homepage/default.phtml";i:2;i:1291667293;}}}?><?php
// file …/templates/Homepage/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '2bf7602798'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbb1c1898abd_content')) { function _cbbb1c1898abd_content($_args) { extract($_args)
?>
Počet fotek: <?php echo count($data['photo']) ?><br />
<br />
<br />

<table border="1">
<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data['photo']) as $photo): if ($iterator->getCounter()%8 == 1): ?><tr><?php endif ?>

        <td>
            <img src="http://farm<?php echo NTemplateHelpers::escapeHtml($photo['farm']) ?>.static.flickr.com/<?php echo NTemplateHelpers::escapeHtml($photo['server']) ?>/<?php echo NTemplateHelpers::escapeHtml($photo['id']) ?>_<?php echo NTemplateHelpers::escapeHtml($photo['secret']) ?>_s.jpg" />
            <br />
            <a href="http://farm<?php echo NTemplateHelpers::escapeHtml($photo['farm']) ?>.static.flickr.com/<?php echo NTemplateHelpers::escapeHtml($photo['server']) ?>/<?php echo NTemplateHelpers::escapeHtml($photo['id']) ?>_<?php echo NTemplateHelpers::escapeHtml($photo['secret']) ?>_b.jpg" target="_blank">velka fotka</a><br />
            <?php echo NTemplateHelpers::escapeHtml($photo['percentage']) ?>%
        </td>
<?php if ($iterator->getCounter()%8 == 0): ?></tr><?php endif ?>

<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>

<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
if (!$_cb->extends) { call_user_func(reset($_cb->blocks['content']), get_defined_vars()); }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
