<?php
require_once 'init.php';
require_once 'models/pagesearch.php';
user::auth("member");
$sql = "SELECT * FROM users";
$result = db::getdb()->query($sql);
$users = [];
$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$amount_per_page = 10;
if (isset($_GET['amount_per_page'])) {
    $amount_per_page = $_GET['amount_per_page'];
}

$searchval = "";
$test = 0;
while($row = $result->fetch_assoc()) {
    $users[] = [
        "firstname"=>$row['user_first'],
        "lastname"=>$row['user_last'],
        "emails"=>json_decode($row['user_email_all']),
        "phones"=>json_decode($row['user_phone'])
    ];
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


