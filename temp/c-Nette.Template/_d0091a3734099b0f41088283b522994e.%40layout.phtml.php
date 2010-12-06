<?php //netteCache[01]000230a:3:{s:4:"time";s:21:"0.46933400 1291667639";s:6:"expire";i:1291667639;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:48:"/var/www/VMW/www/../app/templates//@layout.phtml";i:2;i:1291558418;}}}?><?php
// file …/templates//@layout.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '451ebe80b9'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<meta name="description" content="Nette Framework web application skeleton"><?php if (isset($robots)): ?>
	<meta name="robots" content="<?php echo NTemplateHelpers::escapeHtml($robots) ?>">
<?php endif ?>

	<title>MI-VMW semestral project</title>

	<link rel="stylesheet" media="screen,projection,tv" href="<?php echo NTemplateHelpers::escapeHtml($basePath) ?>/css/screen.css" type="text/css">
	<link rel="stylesheet" media="print" href="<?php echo NTemplateHelpers::escapeHtml($basePath) ?>/css/print.css" type="text/css">
	</head>

<body>
	<?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($flashes) as $flash): ?><div class="flash <?php echo NTemplateHelpers::escapeHtml($flash->type) ?>"><?php echo NTemplateHelpers::escapeHtml($flash->message) ?></div><?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>


<?php NLatteMacros::callBlock($_cb->blocks, 'content', get_defined_vars()) ?>
</body>
</html>
<?php
}
