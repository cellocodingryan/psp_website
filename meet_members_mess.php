<?php
/**
 * Created by PhpStorm.
 * User: cellocodingryan
 * Date: 4/27/18
 * Time: 1:31 AM
 */

echo '

<style>

    /*about us*/







    #acceptedMembers p {
        text-align: center;
        font-size: 4em;
        margin-top: 1em;
        line-height:1.5em;
        color: black;
        font-weight: bolder;
    }


    .jssora02l, .jssora02r {
        display: block;
        position: absolute;
        /* size of arrow element */
        width: 55px;
        height: 55px;
        cursor: pointer;
        background: url(\'member_images/a02.png\') no-repeat;
        overflow: hidden;
    }
    .jssora02l { background-position: -3px -33px; }
    .jssora02r { background-position: -63px -33px; }
    .jssora02l:hover { background-position: -123px -33px; }
    .jssora02r:hover { background-position: -183px -33px; }
    .jssora02l.jssora02ldn { background-position: -3px -33px; }
    .jssora02r.jssora02rdn { background-position: -63px -33px; }
    /* jssor slider thumbnail navigator skin 11 css *//*.jssort11 .p            (normal).jssort11 .p:hover      (normal mouseover).jssort11 .pav          (active).jssort11 .pav:hover    (active mouseover).jssort11 .pdn          (mousedown)*/.jssort11 .p {    position: absolute;    top: 0;    left: 0;    width: 200px;    height: 69px;    background: #181818;}.jssort11 .tp {    position: absolute;    top: 0;    left: 0;    width: 100%;    height: 100%;    border: none;}.jssort11 .i, .jssort11 .pav:hover .i {    position: absolute;    top: 3px;    left: 3px;    width: 60px;    height: 30px;    border: white 1px dashed;}* html .jssort11 .i {    width /**/: 62px;    height /**/: 32px;}.jssort11 .pav .i {    border: white 1px solid;}.jssort11 .t, .jssort11 .pav:hover .t {    position: absolute;    top: 3px;    left: 68px;    width: 129px;    height: 32px;    line-height: 32px;    text-align: center;    color: #fc9835;    font-size: 13px;    font-weight: 700;}.jssort11 .pav .t, .jssort11 .p:hover .t {    color: #fff;}.jssort11 .c, .jssort11 .pav:hover .c {    position: absolute;    top: 38px;    left: 3px;    width: 197px;    height: 31px;    line-height: 31px;    color: #fff;    font-size: 11px;    font-weight: 400;    overflow: hidden;}.jssort11 .pav .c, .jssort11 .p:hover .c {    color: #fc9835;}.jssort11 .t, .jssort11 .c {    transition: color 2s;    -moz-transition: color 2s;    -webkit-transition: color 2s;    -o-transition: color 2s;}.jssort11 .p:hover .t, .jssort11 .pav:hover .t, .jssort11 .p:hover .c, .jssort11 .pav:hover .c {    transition: none;    -moz-transition: none;    -webkit-transition: none;    -o-transition: none;}.jssort11 .p:hover, .jssort11 .pav:hover {    background: #333;}.jssort11 .pav, .jssort11 .p.pdn {    background: #462300;}




    /* jssor slider arrow navigator skin 05 css */
    /*
    .jssora05l                  (normal)
    .jssora05r                  (normal)
    .jssora05l:hover            (normal mouseover)
    .jssora05r:hover            (normal mouseover)
    .jssora05l.jssora05ldn      (mousedown)
    .jssora05r.jssora05rdn      (mousedown)
    */
    .jssora05l, .jssora05r {
        display: block;
        position: absolute;
        /* size of arrow element */
        width: 40px;
        height: 40px;
        cursor: pointer;
        background: url(\'member_images/a17.png\') no-repeat;
        overflow: hidden;
    }
    .jssora05l { background-position: -10px -40px; }
    .jssora05r { background-position: -70px -40px; }
    .jssora05l:hover { background-position: -130px -40px; }
    .jssora05r:hover { background-position: -190px -40px; }
    .jssora05l.jssora05ldn { background-position: -250px -40px; }
    .jssora05r.jssora05rdn { background-position: -310px -40px; }

    /* jssor slider thumbnail navigator skin 01 css */
    /*
    .jssort02 .p            (normal)
    .jssort02 .p:hover      (normal mouseover)
    .jssort02 .p.pav        (active)
    .jssort02 .p.pdn        (mousedown)
    */
    .jssort02 .p {
        position: absolute;
        top: 0;
        left: 0;
        width: 72px;
        height: 72px;
    }

    .jssort02 .t {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }

    .jssort02 .w {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 100%;
        height: 100%;
    }

    .jssort02 .c {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 68px;
        height: 68px;
        border: #000 2px solid;
        box-sizing: content-box;
        background: url(\'member_images/t01.png\') -800px -800px no-repeat;
        _background: none;
    }

    .jssort02 .pav .c {
        top: 2px;
        _top: 0px;
        left: 2px;
        _left: 0px;
        width: 68px;
        height: 68px;
        border: #000 0px solid;
        _border: #fff 2px solid;
        background-position: 50% 50%;
    }

    .jssort02 .p:hover .c {
        top: 0px;
        left: 0px;
        width: 70px;
        height: 70px;
        border: #fff 1px solid;
        background-position: 50% 50%;
    }

    .jssort02 .p.pdn .c {
        background-position: 50% 50%;
        width: 68px;
        height: 68px;
        border: #000 2px solid;
    }

    * html .jssort02 .c, * html .jssort02 .pdn .c, * html .jssort02 .pav .c {
        /* ie quirks mode adjust */
        width /**/: 72px;
        height /**/: 72px;
    }



</style>
<!--<div id="about" class="" style="height: 1000px;">-->

<div class="meet">
    <div id="jssor_1" style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 872px; height: 367.875px; overflow: hidden; visibility: hidden; background-color: #000000;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
            <div style="position:absolute;display:block;background:url(\'member_images/loading.gif\') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
        </div>
        <div data-u="slides" style="cursor: default; position: relative; top: 0px; left: 0px; width: 654px; height: 367.875px; overflow: hidden;">
            <!--<div data-p="112.50" style="display: none;">-->
            <!--<img data-u="image" src="img/002.jpg" />-->
            <!--<div data-u="thumb">-->
            <!--<img class="i" src="img/thumb-002.jpg" />-->
            <!--<div class="t">Banner Rotator</div>-->
            <!--<div class="c">360+ touch swipe slideshow effects</div>-->
            <!--</div>-->
            <!--</div>-->
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Ryan.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Ryan.jpg" />
                    <div class="t">Ryan Waddell</div>
                    <div class="c">Web Developer & Cellist</div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/JohnS.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/JohnS.jpg" />
                    <div class="t">John Sharshar</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Gabe.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Gabe.jpg" />
                    <div class="t">Gabriel Hsieh</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/bridget.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/bridget.jpg" />
                    <div class="t">Bridget Hemesath</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/sean-meet-members-pic.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/sean-meet-members-pic.jpg" />
                    <div class="t">Sean Edwards</div>
                    <div class="c"></div>
                </div>
            </div>

            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Henry.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Henry.jpg" />
                    <div class="t">Henry Deverman</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/avi.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/avi.jpg" />
                    <div class="t">Avi Gotskind</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Bella.JPG" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Bella.JPG" />
                    <div class="t">Bella</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Angelica.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Angelica.jpg" />
                    <div class="t">Angelica Lorenzo</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Sui-Lin.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Sui-Lin.jpg" />
                    <div class="t">Sui Lin Tam</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Greg-meet-members-pic.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Greg-meet-members-pic.jpg" />
                    <div class="t">Gregory Phifer</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Allen.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Allen.jpg" />
                    <div class="t">Allen Dai</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Nikolaj.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Nikolaj.jpg" />
                    <div class="t">Nikolaj Reiser</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Karen.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Karen.jpg" />
                    <div class="t">Karen Dai</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/andre2.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/andre2.jpg" />
                    <div class="t">Andre Battles</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/IMG_8542.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/IMG_8542.jpg" />
                    <div class="t">Marcy & Eric</div>
                    <div class="c"></div>
                </div>
            </div>

            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/zuri3.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/zuri3.jpg" />
                    <div class="t">Zuri Wells</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Shuya.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Shuya.jpg" />
                    <div class="t">Shuya Gong</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/JohnR.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/JohnR.jpg" />
                    <div class="t">John Ringor</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Joshua.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Joshua.jpg" />
                    <div class="t">Joshua Jones</div>
                    <div class="c"></div>
                </div>
            </div>


            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Kevin.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Kevin.jpg" />
                    <div class="t">Kevin Reyes</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Teresa.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Teresa.jpg" />
                    <div class="t">Teresa Puchalski</div>
                    <div class="c"></div>
                </div>
            </div>
            <div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Shumei.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Shumei.jpg" />
                    <div class="t">Shumei Gong</div>
                    <div class="c"></div>
                </div>
            </div><div data-p="112.50" style="display: none;">
                <img data-u="image" src="member_images/Lucia.jpg" />
                <div data-u="thumb">
                    <img class="i" src="member_images/Lucia.jpg" />
                    <div class="t">Lucia Leon</div>
                    <div class="c"></div>
                </div>
            </div>
        </div>
        <!-- Thumbnail Navigator -->
        <div data-u="thumbnavigator" class="jssort11" style="position:absolute;right:0px;top:0px;font-family:Arial, Helvetica, sans-serif;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none;width:218px;height:367.875px;" data-autocenter="2">
            <!-- Thumbnail Item Skin Begin -->
            <div data-u="slides" style="cursor: default;">
                <div data-u="prototype" class="p">
                    <div data-u="thumbnailtemplate" class="tp"></div>
                </div>
            </div>
            <!-- Thumbnail Item Skin End -->
        </div>
        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora02l" style="top:0px;left:8px;width:55px;height:55px;" data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora02r" style="top:0px;right:218px;width:55px;height:55px;" data-autocenter="2"></span>
        <!--<a href="http://www.jssor.com" style="display:none">Bootstrap Carousel</a>-->
    </div>
</div>

<!--</div>-->
<script>jQuery(document).ready(function(b){function c(){var a=e.$Elmt.parentNode.clientWidth;a?(a=Math.min(a,1700),e.$ScaleWidth(a)):window.setTimeout(c,30)}function d(){var a=f.$Elmt.parentNode.clientWidth;a?(a=Math.min(a,800),f.$ScaleWidth(a)):window.setTimeout(d,30)}var e=new $JssorSlider$("jssor_1",{$AutoPlay:!0,$ArrowNavigatorOptions:{$Class:$JssorArrowNavigator$},$ThumbnailNavigatorOptions:{$Class:$JssorThumbnailNavigator$,$Cols:5,$SpacingX:0,$SpacingY:2,$Orientation:2,$Align:0}});c();b(window).bind("load",
        c);b(window).bind("resize",c);b(window).bind("orientationchange",c);var f=new $JssorSlider$("jssor_2",{$AutoPlay:!0,$SlideshowOptions:{$Class:$JssorSlideshowRunner$,$Transitions:[{$Duration:1200,x:.3,$During:{$Left:[.3,.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:-.3,$SlideOut:!0,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:-.3,$During:{$Left:[.3,.7]},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                $Opacity:2},{$Duration:1200,x:.3,$SlideOut:!0,$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:.3,$During:{$Top:[.3,.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:-.3,$SlideOut:!0,$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:-.3,$During:{$Top:[.3,.7]},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:.3,$SlideOut:!0,$Easing:{$Top:$Jease$.$InCubic,
                    $Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:.3,$Cols:2,$During:{$Left:[.3,.7]},$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:.3,$Cols:2,$SlideOut:!0,$ChessMode:{$Column:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:.3,$Rows:2,$During:{$Top:[.3,.7]},$ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:.3,$Rows:2,$SlideOut:!0,
                $ChessMode:{$Row:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:.3,$Cols:2,$During:{$Top:[.3,.7]},$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,y:-.3,$Cols:2,$SlideOut:!0,$ChessMode:{$Column:12},$Easing:{$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:.3,$Rows:2,$During:{$Left:[.3,.7]},$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},
                $Opacity:2},{$Duration:1200,x:-.3,$Rows:2,$SlideOut:!0,$ChessMode:{$Row:3},$Easing:{$Left:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:.3,y:.3,$Cols:2,$Rows:2,$During:{$Left:[.3,.7],$Top:[.3,.7]},$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,x:.3,y:.3,$Cols:2,$Rows:2,$During:{$Left:[.3,.7],$Top:[.3,.7]},$SlideOut:!0,$ChessMode:{$Column:3,$Row:12},$Easing:{$Left:$Jease$.$InCubic,
                    $Top:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,$Delay:20,$Clip:3,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,$Delay:20,$Clip:3,$SlideOut:!0,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,$Delay:20,$Clip:12,$Assembly:260,$Easing:{$Clip:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},{$Duration:1200,$Delay:20,$Clip:12,$SlideOut:!0,$Assembly:260,$Easing:{$Clip:$Jease$.$OutCubic,
                    $Opacity:$Jease$.$Linear},$Opacity:2}],$TransitionsOrder:1},$ArrowNavigatorOptions:{$Class:$JssorArrowNavigator$},$ThumbnailNavigatorOptions:{$Class:$JssorThumbnailNavigator$,$Cols:10,$SpacingX:8,$SpacingY:8,$Align:360}});c();b(window).bind("load",d);b(window).bind("resize",d);b(window).bind("orientationchange",d)});</script>
<script src="js/jssor.slider.mini.js"></script>



'
?>