<?php

include_once "class-autoload.inc.php";

if(isset($_POST['answer'])) {
    $contr = new Contr;
    $contr->changeAnswer($_POST['qid'], $_POST['answer']);
}