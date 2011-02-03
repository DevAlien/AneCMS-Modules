<?php

/**
 * Class for manage the Blog
 *
 * @package Dev-Site => Blog
 * @author Gon�alo Margalho <gsky89@gmail.com>
 * @copyright Dev-House.Com (C) 2006-2008
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class blog {

    /**
     * Add a Comment in the post of Blog
     *
     * @param integer $id_art Id of article
     * @param string $comment Text of Comment
     * @param string $username username of a user that have post a comment
     * @param string $email E-Mail of user that have post a comment
     * @param string $site Site of user that have post a comment
     * @param integer $date microtime of moment that user have post a comment
     * @return boolean
     */
    public static function addComment($id_art, $comment, $username, $email, $site) {
        global $db, $database, $qgeneral;
		
        include './class/akismet.class.php';
        if ($qgeneral['akismetkey'] != '') {
            $ispam = false;
            try {
                $akismet = new Akismet($qgeneral['url_base'], $qgeneral['akismetkey']);
                $akismet->setCommentAuthor($username);
                $akismet->setCommentAuthorEmail($email);
                $akismet->setCommentAuthorURL($site);
                $akismet->setCommentContent($comment);
                $akismet->setPermalink($_SERVER['HTTP_REFERER']);
                $ispam = $akismet->isCommentSpam();
            } catch (Exception $exc) {
                include_once dirname(__FILE__).'/../../class/errors.class.php';
                Errors::saveError($exc->getTraceAsString(), 'akismet');
            }

            if ($ispam)
                $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_comments (id_article, comment, user, email, web, dateinsert, type) values (?, ?, ?, ?, ?, ?, ?)', DBDriver::QUERY, array($id_art, $comment, $username, $email, $site, time(), 0));
            else {
                $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_comments (id_article, comment, user, email, web, dateinsert, type) values (?, ?, ?, ?, ?, ?, ?)', DBDriver::QUERY, array($id_art, $comment, $username, $email, $site, time(), 1));
                $db->query('Update ' . $database['tbl_prefix'] . 'blog_articles set comments = comments + 1 where id = ' . $id_art);
                return true;
            }
        } else {
            $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_comments (id_article, comment, user, email, web, dateinsert, type) values (?, ?, ?, ?, ?, ?, ?)', DBDriver::QUERY, array($id_art, $comment, $username, $email, $site, time(), 1));
            $db->query('Update ' . $database['tbl_prefix'] . 'blog_articles set comments = comments + 1 where id = ?', DBDriver::QUERY, array($id_art));
            return true;
        }
    }

    /**
     * Delete a comment from the Post of Blog
     *
     * @param integer $id Id of comment
     * @return boolean
     */
    public static function deleteComment($id, $id_art) {
        global $db, $database;
        $db->query('Delete From ' . $database['tbl_prefix'] . 'blog_comments where id = ?', DBDriver::QUERY, array($id));
        if ($db->affectedRows() > 0) {
            $db->query('Update ' . $database['tbl_prefix'] . 'blog_articles set comments = comments - 1 where id = ?', DBDriver::QUERY, array($id_art));
            return true;
        }
        return false;
    }

    /**
     * Aprrove a comment that was marked as SPAM or All comments are to approve
     *
     * @param integer $id id of comment to approve
     * @return boolean
     */
    public static function approveComment($id) {
        global $db, $database;
		
        if (is_array($id)){
		$arr = array(1);
            foreach ($id as $id_comment){
                $where .= 'id = ? OR';
				$arr[] = $id_comment;
			}
		}
        else
            return $db->query('Update ' . $database['tbl_prefix'] . 'blog_comments SET type = ? where id = ?', DBDriver::QUERY, array(1, $id));

        return $db->query('Update ' . $database['tbl_prefix'] . 'blog_comments SET type = ? where ' . $where, DBDriver::QUERY, $arr);
    }

    /**
     * Add a Post in Blog
     *
     * @param string $title Title of article
     * @param string $article Text of article
     * @param string $art_more Text of article(More)
     * @param integer $insert_date microtime of moment that user have post the article
     * @param integer $insert_user_id Id of user that have post the article
     * @return boolean
     */
    public static function addArticle($title, $article, $art_more, $insert_date, $insert_user_id) {
        global $db, $database;
        return $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_articles (title, article, art_more, insert_date, insert_user_id, comments) values (?, ?, ?, ?, ?, ?)', DBDriver::QUERY, array($title, $article, $art_more, $insert_date, $insert_user_id, 0));
    }

    /**
     * Add a Post in Blog
     *
     * @param string $title Title of article
     * @param string $article Text of article
     * @param string $art_more Text of article(More)
     * @param integer $insert_date microtime of moment that user have post the article
     * @param integer $insert_user_id Id of user that have post the article
     * @return boolean
     */
    public static function updateArticle($title, $article, $art_more, $id, $date) {
        global $db, $database;
        return $db->query('update ' . $database['tbl_prefix'] . 'blog_articles set title = ?, article = ?, art_more = ?, insert_date = ? where id = ?', DBDriver::QUERY, array($title, $article, $art_more, $date, $id));
    }

    /**
     * Approve Article
     *
     * @param integer $id id of the article
     * @return boolean
     */
    public static function approveArticle($id) {
        global $db, $database;
        return $db->query('Update ' . $database['tbl_prefix'] . 'blog_articles SET type = ?, insert_date = ? where id = ?', DBDriver::QUERY, array(1, time(), $id));
    }

    /**
     * Delete a Article
     *
     * @param integer $id id of the article
     * @return boolean
     */
    public static function deleteArticle($id) {
        global $db, $database;
        return $db->query('Delete From ' . $database['tbl_prefix'] . 'blog_articles where id = ?', DBDriver::QUERY, array($id));
    }

    /**
     * Add Category/Tags in Database
     *
     * @return boolean
     */
    public static function addCategory() {
        global $db, $database;
        return $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_tags');
    }

    /**
     * Get articles for view first page of blog
     *
     * @return array
     */
    public static function getBlog() {
        global $db, $database;
        return $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.*, ' . $database['tbl_prefix'] . 'dev_users.username As username From ' . $database['tbl_prefix'] . 'blog_articles Inner Join ' . $database['tbl_prefix'] . 'dev_users On ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ' . $database['tbl_prefix'] . 'dev_users.id ORDER BY ' . $database['tbl_prefix'] . 'blog_articles.insert_date desc', DBDriver::ALIST);
    }

    public static function getBlogCategory($name) {
        global $db, $database;
        return $db->query('select ' . $database['tbl_prefix'] . 'blog_articles.*, ' . $database['tbl_prefix'] . 'dev_users.username As username  from ' . $database['tbl_prefix'] . 'blog_categories Inner Join ' . $database['tbl_prefix'] . 'blog_articles On ' . $database['tbl_prefix'] . 'blog_articles.id = ' . $database['tbl_prefix'] . 'blog_categories.article_id Inner Join ' . $database['tbl_prefix'] . 'dev_users On ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ' . $database['tbl_prefix'] . 'dev_users.id where ' . $database['tbl_prefix'] . 'blog_categories.name = ? ORDER BY ' . $database['tbl_prefix'] . 'blog_articles.insert_date desc', DBDriver::ALIST, array($name));
    }

    public static function getBlogAuthor($authorid) {
        global $db, $database;
        return $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.*, ' . $database['tbl_prefix'] . 'dev_users.username As username From ' . $database['tbl_prefix'] . 'blog_articles Inner Join ' . $database['tbl_prefix'] . 'dev_users On ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ' . $database['tbl_prefix'] . 'dev_users.id WHERE ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ? ORDER BY ' . $database['tbl_prefix'] . 'blog_articles.insert_date desc', DBDriver::ALIST, array($authorid));
    }

    /**
     * Get single article
     *
     * @param integer $id id of the article
     * @return array
     */
    public static function getArticle($id) {
        global $db, $database;
        if (is_numeric($id))
            return $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.*, ' . $database['tbl_prefix'] . 'dev_users.username As username From ' . $database['tbl_prefix'] . 'blog_articles Inner Join ' . $database['tbl_prefix'] . 'dev_users On ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ' . $database['tbl_prefix'] . 'dev_users.id Where ' . $database['tbl_prefix'] . 'blog_articles.id = ? Order By ' . $database['tbl_prefix'] . 'blog_articles.insert_date Desc', DBDriver::ALIST, array($id));
        else
            return false;
    }

    /**
     * Get list of all articles
     *
     * @return array
     */
    public static function getAllArticles() {
        global $db, $database;
        return $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.*, ' . $database['tbl_prefix'] . 'dev_users.username As username From ' . $database['tbl_prefix'] . 'blog_articles Inner Join ' . $database['tbl_prefix'] . 'dev_users On ' . $database['tbl_prefix'] . 'blog_articles.insert_user_id = ' . $database['tbl_prefix'] . 'dev_users.id Order By ' . $database['tbl_prefix'] . 'blog_articles.insert_date Desc', DBDriver::ALIST, array());
    }

    /**
     * Get all comments for single article
     *
     * @param integer $id id of article
     * @return array
     */
    public static function getComments($id) {
        global $db, $database;
        return $db->query('Select ' . $database['tbl_prefix'] . 'blog_comments.* From ' . $database['tbl_prefix'] . 'blog_comments Where ' . $database['tbl_prefix'] . 'blog_comments.id_article = ? AND ' . $database['tbl_prefix'] . 'blog_comments.type = ? ORDER BY dateinsert', DBDriver::ALIST, array($id, 1));
    }

    public static function setCategories($date, $categories) {
        global $db, $database;
        $idarticle = $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.id from ' . $database['tbl_prefix'] . 'blog_articles where ' . $database['tbl_prefix'] . 'blog_articles.insert_date = ?', DBDriver::AARRAY, array($date));
        $categories = str_replace(', ', ',', $categories);
        $categories = str_replace(' ,', ',', $categories);
        $categories = str_replace(' , ', ',', $categories);
        $cat = explode(',', $categories);
        self::deleteCategories($idarticle['id']);
        foreach ($cat as $nc)
            if ($nc != '')
                $db->query('Insert Into ' . $database['tbl_prefix'] . 'blog_categories (name, article_id) values (?, ?)', DBDriver::QUERY, array($nc, $idarticle['id']));

        $db->query('update ' . $database['tbl_prefix'] . 'blog_articles SET categorieshtml = ? where id = ?', DBDriver::QUERY, array(self::getStringArticleCategories($idarticle['id'], true), $idarticle['id']));
    }

    public static function deleteCategories($id) {
        global $db, $database;
        return $db->query('Delete From ' . $database['tbl_prefix'] . 'blog_categories where article_id = ?', DBDriver::QUERY, array($id));
    }

    public static function getArticleCategories($articleid) {
        global $db, $database;
        return $db->query('Select ' . $database['tbl_prefix'] . 'blog_categories.name from ' . $database['tbl_prefix'] . 'blog_categories where ' . $database['tbl_prefix'] . 'blog_categories.article_id = ?', DBDriver::ALIST, array($articleid));
    }

    public static function getStringArticleCategories($articleid, $links = false) {
        global $db, $database, $qgeneral;
        $categories = self::getArticleCategories($articleid);
        $counted = count($categories);
        $string = '';
        $counter = 0;
        if (!$links) {
            foreach ($categories as $cat => $category) {
                $counter++;
                if ($counter == $counted)
                    $string .= $category['name'];
                else
                    $string .= $category['name'] . ',';
            }
        }
        else {
            foreach ($categories as $cat => $category) {
                $counter++;
                if ($counter == $counted)
                    $string .= '<a href="' . $qgeneral['url_base'] . 'blog/' . $category['name'] . '">' . $category['name'] . '</a>';
                else
                    $string .= '<a href="' . $qgeneral['url_base'] . 'blog/' . $category['name'] . '">' . $category['name'] . '</a>, ';
            }
        }
        return $string;
    }

    public static function getArticleId($date) {
        global $db, $database;
        $idarticle = $db->query('Select ' . $database['tbl_prefix'] . 'blog_articles.id from ' . $database['tbl_prefix'] . 'blog_articles where ' . $database['tbl_prefix'] . 'blog_articles.insert_date = ?', DBDriver::AARRAY, array($date));
        return $idarticle['id'];
    }

}
?>