<?php

require_once 'init.php';
require_once 'models/db.php';
class User_ {
    function __construct($src,$label,$description) {
        $this->src = $src;
        $this->label = $label;
        $this->description = $description;
    }
    public $src;
    public $label;
    public $description;
}
$usersx = [
//    new User_("member_images/JohnS.jpg","John Sharshar",""),
    new User_("member_images/Gabe.jpg","Gabriel Hsieh",""),
    new User_("member_images/bridget.jpg","Bridget Hemesath",""),
//    new User_("member_images/sean-meet-members-pic.jpg","Sean Edwards",""),
//    new User_("member_images/Henry.jpg","Henry Deverman",""),
    new User_("member_images/avi.jpg","Avi Gotskind",""),
//    new User_("member_images/Bella.JPG","Bella",""),
//    new User_("member_images/Angelica.jpg","Angelica Lorenzo",""),
//    new User_("member_images/Sui-Lin.jpg","Sui Lin Tam",""),
//    new User_("member_images/Greg-meet-members-pic.jpg","Gregory Phifer",""),
//    new User_("member_images/Allen.jpg","Allen Dai",""),
//    new User_("member_images/Nikolaj.jpg","Nikolaj Reiser",""),
//    new User_("member_images/Karen.jpg","Karen Dai",""),
//    new User_("member_images/andre2.jpg","Andre Battles",""),
//    new User_("member_images/IMG_8542.jpg","Marcy & Eric",""),
//    new User_("member_images/zuri3.jpg","Zuri Wells",""),
//    new User_("member_images/Shuya.jpg","Shuya Gong",""),
//    new User_("member_images/JohnR.jpg","John Ringor",""),
//    new User_("member_images/Joshua.jpg","Joshua Jones",""),
    new User_("member_images/Kevin.jpg","Kevin Reyes",""),
//    new User_("member_images/Ryan.jpg","Ryan Waddell","Web Developer & Cellist"),
//    new User_("member_images/Teresa.jpg","Teresa Puchalski",""),
    new User_("member_images/Shumei.jpg","Shumei Gong",""),
//    new User_("member_images/Lucia.jpg","Lucia Leon",""),
];
$usersx = mysqli_query(db::getdb(),"SELECT user_uid, user_first, user_last, user_rank FROM users WHERE user_rank > 0 and user_id > 1 ORDER BY user_id asc");

echo $twig->render('about.twig', ['users' => $usersx,"navvars"=>$navvars]);
//?>
<!---->
<!---->
