<?php

include 'libs/load.php';

//static credentials to check the login implemention along with sessions.
$user = 'newuser';
//$password = "test";
$password = isset($_GET['pass']) ? $_GET['pass'] : ""; //getting password from link user provided. (simple if-self function)

$result = null;

if (isset($_GET['logout'])) { //checking with $_GET for loggingout.
    //print(Session::get('session_token'));
    $usrsessiononj = new UserSession(Session::get('session_token'));
    $usrsessiononj->deactivate(); 
    Session::destroy(); //invoking destroy method from Session Class.
    die("Session destroyed, <a href = 'logintest.php'>Login Again</a>"); //script execution will stop/over.
}

/*
* Using Session, enabling the login to presist across session. 
* Session class contains methods  set(), get(). 
* we use it for setting new array key and value in $_SESSION and getting the value stored.
*/

/*
 * The userobj is created once, either from the session username or the successful login result.
*/

/*
 1. Check if session_token is available in PHP Session.
 2. If yes, construct UserSession and see if it's successful.
 3. Check if the session is valid one
 4. If valid, print "Session Validated"
 5. Else, print "Invalid Session and ask User to login.
*/


if (Session::get('session_token')) {
    $token = Session::get('session_token');
    $usersession = UserSession::authorize($token);
    if ($usersession) {
        print("Session Validated.<br>");
        $userobj = new User($user);
        print("Welcome back, " . $userobj->getUsername());
    }
} else {
    print("No Session found, Trying to logging in now...");
    $result = UserSession::authenticate($user, $password);
    if ($result) {
        $userobj = new User($user);
        print("login Success," . $userobj->getUsername());
    } else {
        print("login failed.");
    }
}

// if (Session::get('is_loggedin')) { //checking for existence of is_logged in key in $_SESSION.
//     $username = Session::get('session_username'); //getting value of the key.
//     $userobj = new User($username);
//     print("Welcome back, " . $userobj->getUsername());
// } else {
//     print("No session found, trying to login now.");
//     $result = User::checklogin($user, $password); //invoking login method from User class.On Successful login, user name will be returned and stored in $result .

//     if ($result) {  //if successful.
//         $username = $result;
//         $userobj = new User($username); //creating new user object
//         print("login Success," . $userobj->getUsername()); //refering user object to get the username
//         Session::set('is_loggedin', true); //adding array key and value to $_SESSION.
//         Session::set('session_username', $result);
//     } else {
//         echo "login failed";
//     }
// }

//A way to logout (<<< EOL is the syntax for multiline string in php)
echo <<<EOL
<br><br><a href="logintest.php?logout">Logout</a> 
EOL;