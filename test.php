<pre><?php

include 'libs/load.php';
// print_r("_SERVER");
// print_r($_SERVER);
// print_r("_GET");
// print_r($_GET);
// print_r("_POST");
// print_r($_POST);
// print_r("_FILE");
// print_r($_FILES);
// print_r("_COOKIE");
// print_r($_COOKIE);
// if (signup("ninja", "ninja", "ninja@gmail.com", "9999999999")) {
//     echo "Connection Success";
// } else {
//     echo "Connection Fail";
// }

$mic1 = new Mic();
$mic2 = new Mic();

$mic1->model = "bmw";
$mic2->model = "wmd";

// printf($mic1->model ."\n");
// printf($mic2->model."\n");


// $mic1->light = "rgb";
// $mic1->setLight("blue");
// print($mic1->light);

$mic1->setmodel("hyber ninja");
print("The model of Mic is ".$mic1->getmodel());
?></pre>