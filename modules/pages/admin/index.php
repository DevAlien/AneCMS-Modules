<?php
include '../modules/pages/pages.class.php';
$q = $db->query_array('SELECT defaultid FROM '.$database['tbl_prefix'].'pages_config WHERE id = 1', true);
// save new page
if(isset($_GET['i']) && $_GET['i'] == 0) {
    if(isset($_POST['linkname']) && $_POST['linkname'] != '')
        pages::save($_POST['linkname'], $_POST['linksecurity']);
    else
        pages::save();
    $db->delete_cache();
    $tpl->assign('selected', $q['defaultid']);
    $tpl->assign('pages', pages::getAllPages());
    $tpl->burn('pages', 'tpl');
}
//update page
else if(isset($_GET['i']) && $_GET['i'] > 0) {
    pages::updatePage();
    $db->delete_cache();
    $tpl->assign('selected', $q['defaultid']);
    $tpl->assign('pages', pages::getAllPages());
    $tpl->burn('pages', 'tpl');
}
//make a new page
else if(isset($_GET['m']) && $_GET['m'] == 'new') {
    $tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');

    $tpl->addCSSFile('system/js/markitup/sets/bbcode/style.css');
    $tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');

    $tpl->addJavascript('system/js/markitup/sets/bbcode/set.js');
    $tpl->addOnLoadJS('$(\'#page\').markItUp(bbcode);');
    $tpl->assign('nom', $lang['new']);
    $tpl->assign('pages_title', '');
    $tpl->assign('pages_page', '');
    $tpl->assign('geti', 0);
    $tpl->burn('pages_new', 'tpl');
}
//modify a page
else if(isset($_GET['m']) && $_GET['m'] == 'modify') {
    $tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');

    $tpl->addCSSFile('system/js/markitup/sets/bbcode/style.css');
    $tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');

    $tpl->addJavascript('system/js/markitup/sets/bbcode/set.js');
    $tpl->addOnLoadJS('$(\'#page\').markItUp(bbcode);');
    $pag = pages::getPages();
    $tpl->assign('nom', $lang['modify']);
    $tpl->assign('pages_title', $pag['name']);
    $tpl->assign('pages_page', Tools::htmlToBBCode($pag['text']));
    $tpl->assign('geti', $_GET['pi']);
    $tpl->burn('pages_new', 'tpl');
}
else if(isset($_GET['m']) && $_GET['m'] == 'delete'){
    pages::removePages();
    $tpl->assign('selected', $q['defaultid']);
    $tpl->assign('pages', pages::getAllPages());
    $tpl->burn('pages', 'tpl');
}
else if(isset($_GET['t']) && $_GET['t'] == 'set'){

    $db->query('UPDATE '.$database['tbl_prefix'].'pages_config SET defaultid = \''.$_POST['page'].'\'');
    $tpl->assign('selected', $_POST['page']);
    $tpl->assign('resultmessage', $lang['pages_settedpage']);
    $tpl->assign('color', 'green');
    $tpl->assign('pages', pages::getAllPages());
    $tpl->burn('pages', 'tpl');
}
//view all pages
else {
    
    $tpl->assign('selected', $q['defaultid']);
    $tpl->assign('pages', pages::getAllPages());
    $tpl->burn('pages', 'tpl');
}
?>