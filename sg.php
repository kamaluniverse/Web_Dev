<pre><?php

// setcookie("testcookie", "testvalue", time() + (86400 * 30), "/");

// use Random\Engine\Secure;

include 'libs/load.php';

print("_SESSION");
print_r($_SESSION);

print("_SERVER ");
print_r($_SERVER);

if (isset($_GET['clear'])) {
    print("Clearing ......... \n ");
    Session::unset_all();

}
if (isset($_GET['destroy'])) {
    print("destory ......... \n ");
    Session::destroy();
}

if (Session::isset('a')) {
    print("A already exisst ...value : ".Session::get('a')."\n");
} else {
    Session::set('a', time());
    print("Assigning  New  ...value : $_SESSION[a]\n");
}
?></pre>