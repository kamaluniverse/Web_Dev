<?php

// include_once '/home/Hacker/htdocs/app/libs/includes/Mic.class.php';
include 'includes/Mic.class.php';
include 'includes/Database.class.php';
include 'includes/User.class.php';
include 'includes/Session.class.php';
include 'includes/UserSession.class.php';

global $__site_config;
$__site_config = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/../appconfig.json');


Session::start();
function get_config($key, $default = null)
{
    global $__site_config;
    $array = json_decode($__site_config, true);
    if (isset($array[$key])) {
        return $array[$key];
    } else {
        return $default;
    }
}
function load_template($name)
{

    include $_SERVER['DOCUMENT_ROOT']."/app/_templates/$name.php";
}

function validate_credentials($username, $password)
{
    if ($username == "shadow@shadow.me" and $password == "shadow") {
        return true;
    } else {
        return false;
    }
}



//  function login($user,$pass){
//     $servername = "mysql.selfmade.ninja";
//     $username = "shadow";
//     $password = "iamshadow";
//     $dbname = "shadow_ninja";

//     // Create connection
//     $conn = new mysqli($servername, $username, $password, $dbname);
//     // Check connection
// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
//  }else{

//  }
//  }
