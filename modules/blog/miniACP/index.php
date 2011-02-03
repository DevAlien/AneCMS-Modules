<?php

$tpl = new Template('./modules/blog/miniACP/tpl', false);

if (isset($_GET['p']))
    $qCommentsNotApproved = $db->query_list('SELECT * FROM ' . $database['tbl_prefix'] . 'blog_comments WHERE type = 0 AND id_article =' . Tools::parseGetPost($_GET['p']));
else
    $qCommentsNotApproved = $db->query_list('SELECT * FROM ' . $database['tbl_prefix'] . 'blog_comments WHERE type = 0');
$tpl->assign('count', count($qCommentsNotApproved));
$tpl->assign('CNA', $qCommentsNotApproved);

$tpl->burn('index', 'tpl', false);
?>