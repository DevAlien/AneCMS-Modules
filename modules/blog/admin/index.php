<?php
include '../modules/blog/blog.class.php';
// save new page
if(isset($_GET['i']) && $_GET['i'] == 1) {
    $art = str_replace('<hr style="width: 100%; height: 2px;">', '<hr>', $_POST['article']);
    $art = explode('<hr>', $art);
    if(count($art) > 1 )
        $more = $art[1];
    else
        $more = '';
    $insert_date = time();
    blog::addArticle($_POST['title'], Tools::parseGetPost($art[0], true), Tools::parseGetPost($more, true), $insert_date, $user->getValues('id'));
    blog::setCategories($insert_date,$_POST['categories']);
    if(isset($_POST['twitter']) && $_POST['twitter'] == true) {
        include '../class/twitter.class.php';
        $tweet = new Twitter($qgeneral['twitter_user'], $qgeneral['twitter_password']);
        $success = $tweet->update($qgeneral['title'] . ' Blog: '. $_POST['title'] .' '.Tools::shortUrl($qgeneral['url_base'] . 'blog/' .blog::getArticleId($insert_date) . '/' . Tools::parseTitle($_POST['title'])));

    }
}
//update page
if(isset($_GET['i']) && $_GET['i'] == 2) {
    $art = str_replace('<hr style="width: 100%; height: 2px;">', '<hr>', $_POST['article']);
    $art = explode('<hr>',$art);
    if(count($art) > 1 )
        $more = $art[1];
    else
        $more = '';
    $insert_date = time();
    blog::updateArticle($_POST['title'], Tools::bbcode($art[0], true), $more, $_GET['ai'], $insert_date);
    blog::setCategories($insert_date,$_POST['categories']);
    $tpl->assign('articles', blog::getAllArticles());
    $tpl->burn('blog', 'tpl');
}

else if(isset($_GET['m']) && $_GET['m'] == 'delete') {

    blog::deleteArticle($_GET['ai']);
    $tpl->assign('articles', blog::getAllArticles());
    $tpl->burn('blog', 'tpl');
}
//make a new page
else if(isset($_GET['m']) && $_GET['m'] == 'new') {
    $tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');

    $tpl->addCSSFile('system/js/markitup/sets/bbcode/style.css');
    $tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');

    $tpl->addJavascript('system/js/markitup/sets/bbcode/set.js');
    $tpl->addOnLoadJS('$(\'#notes\').markItUp(bbcode);');
    $tpl->assign('categories', '');
    $tpl->assign('nom', $lang['new']);
    $tpl->assign('title', '');
    $tpl->assign('article', '');
    $tpl->assign('geti', 1);
    $tpl->burn('blog_new', 'tpl');
}
//modify a page
else if(isset($_GET['m']) && $_GET['m'] == 'modify') {
    $tpl->addCSSFile('system/js/markitup/skins/markitup/style.css');

    $tpl->addCSSFile('system/js/markitup/sets/bbcode/style.css');
    $tpl->addJavascript('system/js/markitup/jquery.markitup.pack.js');

    $tpl->addJavascript('system/js/markitup/sets/bbcode/set.js');
    $tpl->addOnLoadJS('$(\'#notes\').markItUp(bbcode);');

    $article = blog::getArticle($_GET['ai']);
    $tpl->assign('categories', blog::getStringArticleCategories($_GET['ai']));
    $tpl->assign('nom', $lang['modify']);
    $tpl->assign('title', $article[0]['title']);
    $tpl->assign('article', Tools::htmlToBBCode($article[0]['article'].$article[0]['art_more']));
    $tpl->assign('article_id', $article[0]['id']);
    $tpl->assign('geti', 2);
    $tpl->burn('blog_new', 'tpl');
}

//view all pages
else {
    $tpl->assign('articles', blog::getAllArticles());
    $tpl->burn('blog', 'tpl');
}

?>