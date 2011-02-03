<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contactusclass
 *
 * @author alien
 */
class ContactUs {

    public static function getText(){
        global $db, $database;

        $text = $db->query('SELECT text FROM '.$database['tbl_prefix'].'contactus_config', DBDriver::AARRAY, array(), array(1));

        return $text['text'];
    }

    public static function saveText($msg){
        global $db, $database;

        $text = $db->query('INSERT INTO '.$database['tbl_prefix'].'contactus_config (text) values (?)', DBDriver::QUERY, array($msg));

        return $text;
    }

    public static function getAll(){
        global $db, $database;

        $text = $db->query_('SELECT * FROM '.$database['tbl_prefix'].'contactus_config', DBDriver::ALIST, array(), array(1));

        return $text;
    }

    public static function updateAll($text, $email){
        global $db, $database;

        $text = $db->query('update '.$database['tbl_prefix'].'contactus_config set text = ?, email = ?', DBDriver::QUERY, array($text, $email));

        return $text;
    }

    public static function getEmail(){
        global $db, $database;

        $email = $db->query_array('SELECT email FROM '.$database['tbl_prefix'].'contactus_config', DBDriver::AARRAY, array(), array(1));
        return $email['email'];
    }

    public static function send() {
        global $qgeneral;

        $mail = new eMail($qgeneral['title'], self::getEmail());
        $mail->subject($qgeneral['title'].': Contactus');
        $mail->to(self::getEmail());

        $text = 'Name: '.$_POST['name'];
        $text .= "\n";
        $text .= 'Email: '.$_POST['email'];
        $text .= "\n";
        $text .= 'Text: '.$_POST['text'];

        $mail->text($text);

        $mail->send();
        return true;
    }
}
?>
