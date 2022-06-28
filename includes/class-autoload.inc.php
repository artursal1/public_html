<?php
// echo "hi";
include_once "session.inc.php";

spl_autoload_register("myAutoLoader");

function myAutoLoader($className) {
    $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(strpos($url, "includes") !== false or strpos($url, "extra") !== false) {
        $path = "../classes/";
    } else {
        $path = "classes/";
    }

    $extension = ".class.php";
    $className = mb_strtolower($className);
    $fileName = $path . $className . $extension;

    if(!file_exists($fileName)) {
        echo $fileName;
    }

    include_once $path . $className . $extension;

}

