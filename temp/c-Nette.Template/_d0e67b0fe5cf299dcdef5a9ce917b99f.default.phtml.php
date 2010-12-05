<?php //netteCache[01]000238a:3:{s:4:"time";s:21:"0.85295600 1291553486";s:6:"expire";i:1291553486;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:56:"/var/www/VMW/www/../app/templates/Homepage/default.phtml";i:2;i:1291239858;}}}?><?php
// file …/templates/Homepage/default.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '36fa355c52'); unset($_extends);


//
// block content
//
if (!function_exists($_cb->blocks['content'][] = '_cbbb1965bc797_content')) { function _cbbb1965bc797_content($_args) { extract($_args)
?>

<div id="header">
	<h1>It works!</h1>

	<h2>Congratulations on your first Nette Framework powered page.</h2>
</div>

<div>
	<p><?php echo NTemplateHelpers::escapeHtml($message) ?></p>

	<a href="http://nette.org" title="Nette Framework - The most innovative PHP framework"><img
	src="<?php echo NTemplateHelpers::escapeHtml($basePath) ?>/images/nette-powered2.gif" width="80" height="15" alt="Nette Framework powered"></a>
</div>

<style>
	body {
		margin: 0;
		padding: 0;
	}

	div {
		padding: .2em 1em;
	}

	#header {
		background: #EEE;
		border-bottom: 1px #DDD solid;
	}

	h1 {
		color: #0056ad;
		font-size: 30px;
	}

	h2 {
		color: gray;
		font-size: 20px;
	}

	img {
		border: none;
	}
</style><?php
}}

//
// end of blocks
//

if ($_cb->extends) { ob_start(); }

if (NSnippetHelper::$outputAllowed) {
if (!$_cb->extends) { call_user_func(reset($_cb->blocks['content']), get_defined_vars()); }  
}

if ($_cb->extends) { ob_end_clean(); NLatteMacros::includeTemplate($_cb->extends, get_defined_vars(), $template)->render(); }
