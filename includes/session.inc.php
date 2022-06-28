<?php

session_start();
// session_unset();
// session_destroy();

if(!isset($_SESSION['uid']) and $_SERVER['REQUEST_URI'] !== "/login.php") {
    header("Location: /login.php");
}