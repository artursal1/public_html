<?php
    include_once "../includes/class-autoload.inc.php";
    $obj = new View();
    $obj->showQuestions($_GET['pageNum']);
?>