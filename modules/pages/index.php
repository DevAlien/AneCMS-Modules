<?php
include './modules/pages/pages.class.php';
	$tpl->assign('page', pages::view());
	$tpl->burn('pages', 'tpl');
?>