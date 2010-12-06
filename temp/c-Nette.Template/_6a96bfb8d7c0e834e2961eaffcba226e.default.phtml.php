<?php //netteCache[01]000244a:3:{s:4:"time";s:21:"0.49014800 1291664689";s:6:"expire";i:1291664689;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:62:"C:\AppServ\www\VMW\www/../app/templates/Homepage/default.phtml";i:2;i:1291662960;}}}?><?php
// file …/templates/Homepage/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '3ace28a276'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb66bf2ab3b6_header')) { function _cbb66bf2ab3b6_header($_args) { extract($_args)
?>
Fotografie (<?php echo count($data['photo']) ?> fotek)
<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb0216b1ea37_content')) { function _cbb0216b1ea37_content($_args) { extract($_args)
?>

<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($data['photo']) as $photo): ?>
<a href="http://farm<?php echo NTemplateHelpers::escapeHtml($photo['farm']) ?>.static.flickr.com/<?php echo NTemplateHelpers::escapeHtml($photo['server']) ?>/<?php echo NTemplateHelpers::escapeHtml($photo['id']) ?>_<?php echo NTemplateHelpers::escapeHtml($photo['secret']) ?>_b.jpg"><img src="http://farm<?php echo NTemplateHelpers::escapeHtml($photo['farm']) ?>.static.flickr.com/<?php echo NTemplateHelpers::escapeHtml($photo['server']) ?>/<?php echo NTemplateHelpers::escapeHtml($photo['id']) ?>_<?php echo NTemplateHelpers::escapeHtml($photo['secret']) ?>_s.jpg" alt="pic" title="pic" class="gallery" /></a>
<?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>

<?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
if (!$_cb->extends) { call_user_func(reset($_cb->blocks['header']), get_defined_vars()); }  if (!$_cb->extends) { call_user_func(reset($_cb->blocks['content']), get_defined_vars()); }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
