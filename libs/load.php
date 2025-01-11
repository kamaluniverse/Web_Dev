<?php

// include_once '/home/Hacker/htdocs/app/libs/includes/Mic.class.php';
include 'includes/Mic.class.php';
include 'includes/Database.class.php';
include 'includes/User.class.php';
include 'includes/Session.class.php';
Session::start();
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
