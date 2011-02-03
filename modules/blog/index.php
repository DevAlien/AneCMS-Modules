<?php
/*
+--------------------------------------------------------------------------
|   Project: Dev-Site - Module: Blog
|   ========================================
|   Copyright: 2006-2008 http://www.Dev-House.Com
|   ========================================
|   Licence Info:  GPL
|   ========================================
|   Author: Gon�alo Margalho <gsky89@gmail.com>
|   ========================================
|   File Name: index.php
|   ========================================
|   Last Modify: 06.02.2008 08:43
+--------------------------------------------------------------------------
*/
include './modules/blog/blog.class.php';
$tpl->setTitle('Blog');
function getArticlePage( $id) {
    global $tpl;
    $id = @intval($id);
    if(!is_int($id))
        return false;
    $news = blog::getArticle(Tools::parseGetPost($id));
    if(!is_array($news))
        return false;
    $tpl->assign('news', $news);
    if($news['0']['comments'] > 0)
        $tpl->assign('comments', blog::getComments(Tools::string_escape($id)));
    return true;
}

if(isset($_GET['p'])) {
    if(isset($_GET['comm']) && isset($_POST['comment']))
        if(isset($_SESSION['logged']))
            blog::addComment($_GET['p'], $_POST['comment'], $user->getValues('username'), $user->getValues('email'), $user->getValues('web'));
        else
            blog::addComment($_GET['p'], $_POST['comment'], $_POST['username'], $_POST['email'], $_POST['web']);
			
    if(getArticlePage($_GET['p']) == false) {
        $tpl->assign('ti', '');
        $tpl->assign('news', blog::getBlog());
        $tpl->burn('blog', 'tpl');
    }
    else
        $tpl->burn('blog_show_page', 'tpl');
}
else if(isset($_GET['d'])) {
    if($user!==false && $user->isOnGroup('Administrator')) {
        blog::deleteComment($_GET['d'], $_GET['ida']);
        getArticlePage($_GET['ida']);
        $tpl->burn('blog_show_page', 'tpl');
    }
    else {
        $tpl->assign('title_notify', 'Non consentito');
        $tpl->assign('message_notify', 'Non puoi eseguire quest\'azione, furbacchione!!!');
        $tpl->burn('notify', 'tpl');
    }
}
else if(isset($_GET['a'])){
        $tpl->assign('news', blog::getBlogAuthor(Tools::parseGetPost($_GET['a'])));
        $tpl->assign('ti', ': ' . $_GET['an']);
        $tpl->burn('blog', 'tpl');
}
else if(isset($_GET['cat'])){
        $tpl->assign('news', blog::getBlogCategory(Tools::parseGetPost($_GET['cat'])));
        $tpl->assign('ti', ': ' . $_GET['cat']);
        $tpl->burn('blog', 'tpl');
}
else {
    $tpl->assign('ti', '');
    $tpl->assign('news', blog::getBlog());
    $tpl->burn('blog', 'tpl');
}

?>