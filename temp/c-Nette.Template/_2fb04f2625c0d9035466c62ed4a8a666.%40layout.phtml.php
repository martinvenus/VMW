<?php //netteCache[01]000236a:3:{s:4:"time";s:21:"0.51498900 1291664689";s:6:"expire";i:1291664689;s:9:"callbacks";a:1:{i:0;a:3:{i:0;a:2:{i:0;s:6:"NCache";i:1;s:9:"checkFile";}i:1;s:54:"C:\AppServ\www\VMW\www/../app/templates//@layout.phtml";i:2;i:1291663173;}}}?><?php
// file …/templates//@layout.phtml
//

$_cb = NLatteMacros::initRuntime($template, NULL, '2f4ab9d9fd'); unset($_extends);

if (NSnippetHelper::$outputAllowed) {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>VMW</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
    </head>
    <body>
        <div id="top_menu">
            <ul class="menu">
                <li><a href="index.html" class="nav">home</a></li>
            </ul>
        </div>
        <div id="main_content">
            <div id="top_banner">
                <a href="index.html"><img src="images/logo.jpg" width="230" height="130" alt="home" title="logo" border="0" class="logo" /></a>
            </div>

            <div id="page_content">

                <div class="title">
<?php NLatteMacros::callBlock($_cb->blocks, 'header', get_defined_vars()) ?>
                </div>
                <div class="content_text">

                    <?php foreach ($iterator = $_cb->its[] = new NSmartCachingIterator($flashes) as $flash): ?><div class="flash <?php echo NTemplateHelpers::escapeHtml($flash->type) ?>"><?php echo NTemplateHelpers::escapeHtml($flash->message) ?></div><?php endforeach; array_pop($_cb->its); $iterator = end($_cb->its) ?>


<?php NLatteMacros::callBlock($_cb->blocks, 'content', get_defined_vars()) ?>


                </div>



            </div>

        </div>

        <div id="footer">
            <div id="footer_content">
                <div id="copyrights">
                    Quartz Solution.&copy; All Rights Reserved 2007
                </div>

                <div id="madeby">
                    <a href="http://www.csscreme.com"><img src="images/csscreme_link.jpg" width="125" height="40"  border="0" alt="csscreme" title="csscreme"/></a>
                </div>
            </div>

        </div>

    </body>
</html>

<?php
}
