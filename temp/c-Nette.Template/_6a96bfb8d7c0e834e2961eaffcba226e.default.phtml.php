<?php //netteCache[01]000244a:3:{s:4:"time";s:21:"0.74207900 1291668307";s:6:"expire";i:1291668307;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:62:"C:\AppServ\www\VMW\www/../app/templates/Homepage/default.phtml";i:2;i:1291662960;}}}?><?php
// file …/templates/Homepage/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '531809d26b'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb244a543913_header')) { function _cbb244a543913_header($_args) { extract($_args)
?>
Fotografie (<?php echo count($data['photo']) ?> fotek)
<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb04f2570428_content')) { function _cbb04f2570428_content($_args) { extract($_args)
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
