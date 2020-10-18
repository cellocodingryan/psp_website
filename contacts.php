<?php
require_once 'init.php';
require_once 'models/pagesearch.php';
user::auth("member");
$sql = "SELECT * FROM users WHERE user_rank > 0";
$result = db::getdb()->query($sql);
$users = [];
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$amount_per_page = 30;
if (isset($_GET['amount_per_page'])) {
    $amount_per_page = $_GET['amount_per_page'];
}

$searchval = "";
$test = 0;
function formatphone($number) {
    for ($i = 0;$i < count($number);++$i) {

        $number[$i][1] = preg_replace('~.*(\d{3})[^\d]{0,7}(\d{3})[^\d]{0,7}(\d{4}).*~', '($1) $2-$3', $number[$i][1]);

    }
    return $number;
}
function isJson($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
function getAddress($address) {

    if (isJson($address)) {

    } else {

    }
}
while($row = $result->fetch_assoc()) {
    $users[] = [
        "username"=>$row['user_uid'],
        "firstname"=>$row['user_first'],
        "lastname"=>$row['user_last'],
        "emails"=>count(json_decode($row['user_email_all'])) > 0?json_decode($row['user_email_all']):$row['user_email'],
        "phones"=>formatphone(json_decode($row['user_phone'])),
        "address"=>[]
    ];
    if (isJson($row['address'])) {
        $address = json_decode($row["address"]);
        foreach ($address as $v) {
            $users[count($users)-1]["address"][] = $v;
        }
    }else {
        $users[count($users)-1]["address"] = $row['address'];

    }
    ++$test;
}
//var_dump($test);
//var_dump(count($users));
$pagesearch = new pagesearch($users,5,$amount_per_page);
if (isset($_GET['search'])) {
    $searchval = $_GET['search'];
    $pagesearch->search($searchval);
}
$pagesearch->set_page($page);

echo $twig->render("contacts.twig",["navvars"=>$navvars,"contacts"=>$pagesearch->get_array(),"amount_per_page"=>$amount_per_page,"currentpage"=>$page,"pageoptions"=>$pagesearch->get_page_options(),"searchval"=>$searchval]);
exit();
?>


