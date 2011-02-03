<?php
/**
 * Use this class for manage the Downloads
 *
 * @package Dev-Site => Downloads
 * @author Gon�alo Margalho <gsky89@gmail.com>
 * @copyright Dev-House.Com (C) 2006-2008
 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License
 * @version 1.0
 */
class pages {

    public static function view() {
        global $db, $database;
        if(isset($_GET['p']))
            return $db->query('SELECT * FROM '.$database['tbl_prefix'].'pages_pages WHERE id = ?', DBDriver::ALIST, array($_GET['p']));
        else
            return $db->query('SELECT * FROM '.$database['tbl_prefix'].'pages_pages WHERE id = ?',DBDriver::ALIST, array(self::getDefaultPage()), array(), true);
    }
    public static function getPages() {
        global $db, $database;
        if(isset($_GET['pi']))
            return $db->query('SELECT * FROM '.$database['tbl_prefix'].'pages_pages WHERE id = ?', DBDriver::AARRAY, array($_GET['pi']));
        else
            return $db->query('SELECT * FROM '.$database['tbl_prefix'].'pages_pages WHERE id = ?', DBDriver::AARRAY, array(self::getDefaultPage()));
    }

    public static function getAllPages() {
        global $db, $database;
    return $db->query('SELECT p.id, p.name, p.time, u.username as who FROM '.$database['tbl_prefix'].'pages_pages AS p INNER JOIN '.$database['tbl_prefix'].'dev_users AS u ON u.id = p.who', DBDriver::ALIST);
    }
    public static function removePages() {
        global $db, $database;
        return $db->query('DELETE FROM '.$database['tbl_prefix'].'pages_pages WHERE id = ?', DBDriver::QUERY, array($_GET['id']));
    }
    public static function save($link = null, $sec = null) {
        global $db, $database, $user;
        if(isset($link) && $link != '') {
            $id = $db->query('SELECT MAX(id) as id FROM '.$database['tbl_prefix'].'pages_pages', DBDriver::AARRAY);
            $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_menus (type, name, view, link, position) VALUES (?, ?, ?, ?, ?)', DBDriver::QUERY, array(1, $link, $sec, ($id['id'] + 1), acp::getNextPosition(1)));
        }
        return $db->query('INSERT INTO '.$database['tbl_prefix'].'pages_pages (name, text, who, time) VALUES (?, ?, ?, ?)', DBDriver::QUERY, array($_POST['pagename'], Tools::bbcode($_POST['page']), $user->getValues('id'), time()));
    }

    public static function updatePage(){
        global $db, $database, $user;
        return $db->query('UPDATE '.$database['tbl_prefix'].'pages_pages SET name = ?, text = ?, who = ?, time = ? WHERE id = ?', DBDriver::QUERY, array($_POST['pagename'], Tools::bbcode($_POST['page']), $user->getValues('id'), time(), $_GET['i']));
    }

    public static function getDefaultPage(){
        global $db, $database;
        $q = $db->query('SELECT defaultid FROM '.$database['tbl_prefix'].'pages_config WHERE id = ?', DBDriver::AARRAY, array(1), array(), true);
        return $q['defaultid'];
    }
}
?>