<?php

include_once "class-autoload.inc.php";

if(isset($_POST['submit'])) {

    $uid = $_POST['uid'];
    $pwd = $_POST['pwd'];

    $contr = new Contr();
    if($contr->login($uid, $pwd) == true) {
        $_SESSION['uid'] = $uid;
        header("Location: /index.php");
    } else {
        header("Location: /login.php?error");
    }

}