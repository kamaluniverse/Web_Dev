<?php


if(isset($_GET['clear'])){
    print("Clearing ......... \n ");
    session_unset();
}

if(isset($_GET['destroy'])){
    print("destory ......... \n ");
    session_destroy();
}