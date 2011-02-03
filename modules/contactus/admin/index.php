<?php

include '../modules/contactus/contactus.class.php';

$tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');

$tpl->addCSSFile('system/js/markitup/sets/bbcode/style.css');
$tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');

$tpl->addJavascript('system/js/markitup/sets/bbcode/set.js');
$tpl->addOnLoadJS('$(\'#notes\').markItUp(bbcode);');

if (isset($_GET['m'])) {
    ContactUs::updateAll(Tools::parseGetPost($_POST['text'], true), Tools::parseGetPost($_POST['email'], false));
}
$contactus = ContactUs::getAll();

    $tpl->assign('email', $contactus[0]['email']);
    $tpl->assign('text', Tools::htmlToBBCode($contactus[0]['text']));
$tpl->burn('contactus', 'tpl');
?>
