<?php
if(isset($_GET['a'])){
include './class/installmodule.class.php';
$im = new InstallModule('blog');
$im->install();

}
else if(isset($_GET['d'])){
    include './modules/packager/packager.class.php';
    $m = new Packager($_GET['d'], Packager::MODULE);
    $m->downloadFile();
}
else{

include './modules/packager/packager.class.php';
$m = new Packager('showroom', Packager::MODULE);
$m->addDir('./modules/showroom');
$m->createPackage();
echo serialize(array('users'));
echo '<a href="?mode=packager&d=blog">link</a>';
}
?>