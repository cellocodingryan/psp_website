
<?php
require_once 'init.php';
class User {
    function __construct($src,$label,$description) {
        $this->src = $src;
        $this->label = $label;
        $this->description = $description;
    }
    public $src;
    public $label;
    public $description;
}
$users = [
    new User("member_images/JohnS.jpg","John Sharshar",""),
    new User("member_images/Gabe.jpg","Gabriel Hsieh",""),
    new User("member_images/bridget.jpg","Bridget Hemesath",""),
    new User("member_images/sean-meet-members-pic.jpg","Sean Edwards",""),
    new User("member_images/Henry.jpg","Henry Deverman",""),
    new User("member_images/avi.jpg","Avi Gotskind",""),
    new User("member_images/Bella.JPG","Bella",""),
    new User("member_images/Angelica.jpg","Angelica Lorenzo",""),
    new User("member_images/Sui-Lin.jpg","Sui Lin Tam",""),
    new User("member_images/Greg-meet-members-pic.jpg","Gregory Phifer",""),
    new User("member_images/Allen.jpg","Allen Dai",""),
    new User("member_images/Nikolaj.jpg","Nikolaj Reiser",""),
    new User("member_images/Karen.jpg","Karen Dai",""),
    new User("member_images/andre2.jpg","Andre Battles",""),
    new User("member_images/IMG_8542.jpg","Marcy & Eric",""),
    new User("member_images/zuri3.jpg","Zuri Wells",""),
    new User("member_images/Shuya.jpg","Shuya Gong",""),
    new User("member_images/JohnR.jpg","John Ringor",""),
    new User("member_images/Joshua.jpg","Joshua Jones",""),
    new User("member_images/Kevin.jpg","Kevin Reyes",""),
    new User("member_images/Ryan.jpg","Ryan Waddell","Web Developer & Cellist"),
    new User("member_images/Teresa.jpg","Teresa Puchalski",""),
    new User("member_images/Shumei.jpg","Shumei Gong",""),
    new User("member_images/Lucia.jpg","Lucia Leon",""),
];
echo $twig->render('about.twig', ['users' => $users,"current"=>"about"]);
?>


