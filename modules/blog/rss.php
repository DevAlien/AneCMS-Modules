<?php
    include 'modules/blog/blog.class.php';

    $xml = new RssWriter();

    $ns = array(
         'slash' => 'http://purl.org/rss/1.0/modules/slash/'
        ,'content' => 'http://purl.org/rss/1.0/modules/content/'
        ,'wfw' => 'http://wellformedweb.org/CommentAPI/'
        ,'dc' => 'http://purl.org/dc/elements/1.1/'
        ,'atom' => 'http://www.w3.org/2005/Atom'
    );
    $xml->AddNamespaces($ns);


// ADD CHANNEL TAGS
    $channelTags = array(
         'title' => $qgeneral['title']
        ,'link' => $qgeneral['url_base'].'blog'
        ,'description' => $qgeneral['descr']
        ,'generator' => 'ANE CMS'
        ,'language' => 'en-us'
        ,'lastBuildDate' => date('D, d M Y H:i:s O', time())//date('D, d M Y H:i:s O', time())
        
    );
    $xml->AddChannelTags($channelTags);
    $xml->addAtomLink('http://'.$qgeneral['url_base'].'rss/blog');
        $itemTags = array();
        if(isset($_GET['cat']))
            $blog = $db->query_list('select '.$database['tbl_prefix'].'blog_articles.*, '.$database['tbl_prefix'].'dev_users.username As username  from '.$database['tbl_prefix'].'blog_categories Inner Join '.$database['tbl_prefix'].'blog_articles On '.$database['tbl_prefix'].'blog_articles.id = '.$database['tbl_prefix'].'blog_categories.article_id Inner Join '.$database['tbl_prefix'].'dev_users On '.$database['tbl_prefix'].'blog_articles.insert_user_id = '.$database['tbl_prefix'].'dev_users.id where '.$database['tbl_prefix'].'blog_categories.name = \''.$_GET['cat'].'\'  ORDER BY '.$database['tbl_prefix'].'blog_articles.insert_date desc');
        else
            $blog = $db->query_list('Select '.$database['tbl_prefix'].'blog_articles.*, '.$database['tbl_prefix'].'dev_users.username As username From '.$database['tbl_prefix'].'blog_articles Inner Join '.$database['tbl_prefix'].'dev_users On '.$database['tbl_prefix'].'blog_articles.insert_user_id = '.$database['tbl_prefix'].'dev_users.id ORDER BY '.$database['tbl_prefix'].'blog_articles.insert_date desc');
    foreach($blog as $b => $value){
        if(strlen($value['art_more']) > 5 )
            $c = '<br />Continue reading <a href="'.$qgeneral['url_base'].'blog/'.$value['id'].'/'.Tools::parseTitle($value['title']).'">here</a>';
        else
            $c = '';
        $array = array(
            'title' => $value['title']
            ,'link' => $qgeneral['url_base'].'blog/'.$value['id'].'/'.Tools::parseTitle($value['title'])
            ,'guid' => $qgeneral['url_base'].'blog/'.$value['id'].'/'.Tools::parseTitle($value['title'])
            ,'description' => htmlspecialchars($value['article']).$c
            //,'slash:comments' => $value['comments']
            ,'comments' => $qgeneral['url_base'].'blog/'.$value['id'].'/'.Tools::parseTitle($value['title']).'#comments'
            ,'pubDate' => date('D, d M Y H:i:s O',$value['insert_date'])
            ,'category' => 'PHP');

        $itemTags[] = $array;
    }
    // ADD ENTRIES // A bidimensional array is required!
    
    $xml->AddItems($itemTags);


    // END DOCUMENT
    $xml->EndDocument();

    $xml->Display();

?>