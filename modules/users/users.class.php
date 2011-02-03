<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of usersclass
 *
 * @author Gonçalo
 */
class Users {

    public static function addGroup($name, $description) {
        global $db, $database;

        $qNameGroups = $db->query('SELECT name FROM '.$database['tbl_prefix'].'dev_groups where name = ?', DBDriver::AARRAY, array($name));
        if(is_array($qNameGroups))
            return false;
        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_groups (name, description) values (?, ?)', DBDriver::QUERY, array($name, $description));

        return true;
    }

    public static function setGroupToUser($iduser, $idgroup) {
        global $db, $database;

        $db->query('INSERT INTO '.$database['tbl_prefix'].'dev_usersgroups (iduser, idgroup) values (?, ?)', DBDriver::QUERY, array($iduser, $idgroup));

        return true;
    }
    
    public static function removeGroupFromUser($iduser, $idgroup) {
        global $db, $database;

        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_usersgroups where iduser = ? AND idgroup = ?', DBDriver::QUERY, array($iduser, $idgroup));

        return true;
    }
    
    public static function searchUsers($nickpart) {
        global $db, $database;

        $qUsers = $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_users where username LIKE \'%'.$nickpart.'%\'', DBDriver::ALIST);
        if(is_array($qUsers))
            return $qUsers;
        return false;
    }

    public static function removeUser($id) {
        global $db, $database;
        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_users where id = ?', DBDriver::QUERY, array($id));

        return true;
    }

    public static function removeGroup($id) {
        global $db, $database;
        $db->query('DELETE FROM '.$database['tbl_prefix'].'dev_groups where id = ?', DBDriver::QUERY, array($id));

        return true;
    }

    public static function getAllUsers(){
        global $db, $database;

        return $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_users', DBDriver::ALIST);

    }

    public static function getAllGroups(){
        global $db, $database;

        return $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_groups', DBDriver::ALIST);

    }

    public static function getUser($user){
        global $db, $database;

        return $db->query('SELECT * FROM '.$database['tbl_prefix'].'dev_users where id = ?', DBDriver::ALIST, array($user));

    }

public static function getUserGroups($user){
        global $db, $database;

        return $db->query('SELECT g.* FROM '.$database['tbl_prefix'].'dev_usersgroups ug inner join '.$database['tbl_prefix'].'dev_groups g on g.id = ug.idgroup where iduser = ?', DBDriver::ALIST, array($user));

    }

public static function getRemainedUserGroups($user){
        global $db, $database;
        return $db->query('Select * from '.$database['tbl_prefix'].'dev_groups where id NOT IN (SELECT idgroup from '.$database['tbl_prefix'].'dev_usersgroups where iduser = ?)', DBDriver::ALIST, array($user));
	
    }
    public static function updateUser($id, $username, $email, $web){
        global $db, $database;

        return $db->query('UPDATE '.$database['tbl_prefix'].'dev_users set username = ?, email = ?, web = ? WHERE id = ?', DBDriver::QUERY, array($username, $email, $web, $id));

    }
}
?>
