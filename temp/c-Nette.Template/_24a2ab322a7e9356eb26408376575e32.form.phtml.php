<?php //netteCache[01]000241a:3:{s:4:"time";s:21:"0.01798900 1291668119";s:6:"expire";i:1291668119;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:59:"C:\AppServ\www\VMW\www/../app/templates/Homepage/form.phtml";i:2;i:1291668115;}}}?><?php
// file …/templates/Homepage/form.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, 'f2494d826e'); unset($_extends);


//
// block header
//
if (!function_exists($_cb->blocks['header'][] = '_cbb192a9f5139_header')) { function _cbb192a9f5139_header($_args) { extract($_args)
?>
Parametry vyhledávání
<?php
}}


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbb947b6f1cde_content')) { function _cbb947b6f1cde_content($_args) { extract($_args)
;$control->getWidget("mainForm")->render() ;
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
if (!$_cb->extends) { call_user_func(reset($_cb->blocks['header']), get_defined_vars()); }  if (!$_cb->extends) { call_user_func(reset($_cb->blocks['content']), get_defined_vars()); }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
