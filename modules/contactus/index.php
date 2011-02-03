<?php
include './class/captcha.class.php';
include './modules/contactus/contactus.class.php';
include './class/mail.class.php';

if(isset($_POST['name']) && ($_SESSION['captchacode'] == $_POST['code'])){
    
        if(ContactUs::send()){
            $tpl->assign('title_notify', $lang['compli']);
            $tpl->assign('message_notify', $lang['contactus_successfull']);
        }
        $tpl->burn('notify', 'tpl');
}
else{
    $captcha = new Captcha();
    $tpl->assign('captcha', $captcha->createImage());
    $_SESSION['captchacode'] = $captcha->getCode();
    $tpl->assign('text', ContactUs::getText());
    $tpl->burn('contactus', 'tpl');
}
?>