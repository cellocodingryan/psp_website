<?php
require_once 'init.php';
require_once 'models/pagesearch.php';
require_once 'models/stats.php';

user::auth("director");

$page = 0;
if (isset($_GET['page'])) {
    $page = $_GET['page'];
}

$amount_per_page = 30;
if (isset($_GET['amount_per_page'])) {
    $amount_per_page = $_GET['amount_per_page'];
}

$searchval = "";

$userid = isset($_GET['userid']) ? $_GET['userid'] : null;

$pagesearch = new pagesearch(stats::get_all_stats($page*$amount_per_page,$amount_per_page,$userid),5,$amount_per_page);
if (isset($_GET['search'])) {
    $searchval = $_GET['search'];
    $pagesearch->search($searchval);
}
$pagesearch->set_page($page);
echo $twig->render("stats.twig",["navvars"=>$navvars,"stats"=>$pagesearch->get_array(),"amount_per_page"=>$amount_per_page,"currentpage"=>$page,"pageoptions"=>$pagesearch->get_page_options(),"searchval"=>$searchval]);
exit();
?>


