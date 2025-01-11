<?php

use Random\Engine\Secure;

include 'libs/load.php';

$user = "ninja";
$pass = "ninja";
$result = null;

if (isset($_GET['logout'])) {
    Session::destroy();
    die("Destroying ........");
}


if (Session::get('is_login')) {
    $userdata = Session::get('session_username');
    print("Welcome back . $userdata[username]");
    $result = $userdata;
} else {
    print("no session found . try again to login now ");
    $result = User::login($user, $pass);
}

if ($result) {
    print("Login Success ,$result[username]");
    Session::set('is_login', true);
    Session::set('session_username', $result);
} else {
    print("Login Failed");
}

echo <<<log
<br><br><a href="logintest.php?logout">Logout</a>
log;
