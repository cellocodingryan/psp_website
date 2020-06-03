/**
 * Created by cellocodingryan on 1/17/18.
 */
var name = "name";
var title_message="The Percussion Scholarship Program";
var currentSpot = -1;

function moveTitle() {
    ++currentSpot;
    if (title_message.length-currentSpot <= 20 && title_message.length-currentSpot > 0) {
        document.title = title_message.substr(currentSpot,30) /* filler_space + title_message.substr(0,20)*/;
    } else if (title_message.length-currentSpot === 0) {
        currentSpot = 0;
        document.title = title_message.substr(currentSpot,30);
    }
    else {
        document.title = title_message.substr(currentSpot,30);
    }
}

if ($(".welcome_article").length !== 0) {
    $.get('config_files/promo_videos.txt', function(result) {
        var promo_video_config = JSON.parse(result);
        for (var i=0;i<promo_video_config.promo_videos.length;i++) {
            var newVideoTagContainer = document.createElement("div");
            newVideoTagContainer.setAttribute("class","col promo_videos promo_videos"+i);

            var newVideoTag = document.createElement("video");
            newVideoTag.setAttribute("height","100%");
            newVideoTag.setAttribute("width","100%");
            newVideoTag.setAttribute("controls","");
            newVideoTag.setAttribute("poster","images/"+promo_video_config.promo_videos[i]+".jpg");
            newVideoTag.src = "videos/"+promo_video_config.promo_videos[i]+".mp4";
            $(".video_container").append(newVideoTagContainer);
            $(".promo_videos"+i).append(newVideoTag);
        }
        $(".video_container h1").remove();
    });
}

function add_video_to_video_tab(urls) {
    $(".video_tab").append("<div class=\"row\">\n" +
        "        <div class=\"col-md remove1\">\n" +
        "            <div class=\"wrapper\">\n" +
        "                <div class=\"h_iframe\">" +
        "\n" +
        "                    <img class=\"ratio\" src=\"images/video_loading_image.png\"/>\n" +
        "                    <iframe src=\" "+urls[0]+ "  \" frameborder=\"0\"  allowfullscreen></iframe>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "        <div class=\"col-md remove2\">\n" +
        "            <div class=\"wrapper\">\n" +
        "                <div class=\"h_iframe\">" +
        "\n" +
        "                    <img class=\"ratio\" src=\"images/video_loading_image.png\"/>\n" +
        "                    <iframe src=\" "+ urls[1] +"  \" frameborder=\"0\" allowfullscreen></iframe>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "        <div class=\"col-md remove3\">\n" +
        "            <div class=\"wrapper\">\n" +
        "                <div class=\"h_iframe\">" +
        "\n" +
        "                    <img class=\"ratio\" src=\"images/video_loading_image.png\"/>\n" +
        "                    <iframe src=\"  " + urls[2] + "  \" frameborder=\"0\" allowfullscreen></iframe>\n" +
        "                </div>\n" +
        "            </div>\n" +
        "        </div>\n" +
        "    </div>");
}

if ($('.video_tab').length !== 0) {
    $.get('config_files/video_tab.txt', function (result) {
        var video_urls = JSON.parse(result);
        var i = 0;
        var urls = ["https://www.youtube.com/embed/32W2IBkVqUk?rel=0",
            "https://www.youtube.com/embed/32W2IBkVqUk?rel=0",
            "https://www.youtube.com/embed/32W2IBkVqUk?rel=0"];
        if (video_urls.video_tab_urls.length > 3 && (video_urls.video_tab_urls.length % 3) !== 0) {
            for (i = 0; i < video_urls.video_tab_urls.length % 3; ++i) {
                urls[i] = "https://www.youtube.com/embed/" + video_urls.video_tab_urls[i].substr(32) + "?rel=0";
            }
            alert('test');
            add_video_to_video_tab(urls);
            for (; i < 3; ++i) {
                $(".remove" + i).remove();
            }
        }
        for (; i < video_urls.video_tab_urls.length;) {
            for (var j = 0; j < 3 && i < video_urls.video_tab_urls.length; i++, j++) {
                urls[j] = "https://www.youtube.com/embed/" + video_urls.video_tab_urls[i].substr(32) + "?rel=0";
            }
            add_video_to_video_tab(urls);
        }
    });
}

function fixFaq() {
    $(function() {
        var $accordian = $(".accordion");
        $accordian.find('.answer').slideUp(0);
        $("#faq").css("display","block");
    });
}
//frequently asked questions js
fixFaq();
$(function() {
    $('.accordion').each(function () {

        var $accordian = $(this);
        $accordian.find('.question').on('click', function () {

            $accordian.find('.answer').slideUp(500);
            $('h2 img').removeClass("faqDefault");

            if ($(this).next().is(':visible')) {

            }else{

                $(this).next().slideDown(500);
                $('h2 img',this).addClass("faqDefault");
                $(this).next().text()
            }

        });
    });
});

//
if ($('.events_image').length !== 0) {
    ////alert("test");
    $.get('config_files/events.txt', function (result) {
        ////alert("test");
        var events = JSON.parse(result);
        if (events.calendar.length > 0) {
            var weekday = new Array(7);
            weekday[0] = "Sunday";
            weekday[1] = "Monday";
            weekday[2] = "Tuesday";
            weekday[3] = "Wednesday";
            weekday[4] = "Thursday";
            weekday[5] = "Friday";
            weekday[6] = "Saturday";
            var month = new Array(12);
            month[0] = "January";
            month[1] = "February";
            month[2] = "March";
            month[3] = "April";
            month[4] = "May";
            month[5] = "June";
            month[6] = "July";
            month[7] = "August";
            month[8] = "September";
            month[9] = "October";
            month[10] = "November";
            month[11] = "December";
            $(".events_image").after("<div class=\"container\" id=\"event_page\"> </div>");
            for (var i = 0; i < events.calendar.length; i++) {
                var date = new Date(month[events.calendar[i][0] - 1] + " " + events.calendar[i][1] + ", 20" + events.calendar[i][2] + " " + events.calendar[i][3] + ":" + events.calendar[i][4] + ":00");
                // //////alert(month[events.calendar[i][0]-1] + " " + events.calendar[i][1] + ", 20" + events.calendar[i][2] + " " + events.calendar[i][3] + ":" + events.calendar[i][4] + ":00");
                // //////alert(date.getYear());
                var ampm;
                var hour;
                if (date.getHours() > 12) {
                    ampm = "PM";
                    hour = date.getHours() - 12;
                } else {
                    hour = date.getHours();
                    ampm = "AM";
                }
                var minutes = ((date.getMinutes() === 0) ? "00" : date.getMinutes());
                $("#event_page").append("<div class=\"row\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ")").append("<div class=\"col\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ")").append("<div class=\"col\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ")").append("<div class=\"col\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-of-type(1)").append("<div class=\"events_icon\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(1) .events_icon").append("<strong>" + month[date.getMonth()] + "</strong>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(1) .events_icon").append("<span>" + events.calendar[i][1] + "</span>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(1) .events_icon").append("<em>" + weekday[date.getDay()] + "</em>");
                //
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(2)").append("<h1>" + events.calendar[i][5] + "</h1>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(2)").append("<h2>" + month[date.getMonth()] + " " + events.calendar[i][1] + ", 20" + events.calendar[i][2] + "</h2>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(2)").append("<h2>" + hour + ":" + minutes + " " + ampm + "</h2>");
                // $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(2)").append("<h2>" + "(" + date.getYear() + ")" + "</h2>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(2)").append("<p> Symphony Center<br>220 S. Michigan Ave.<br>Chicago, Illinois</p>");

                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(3)").append("<div class=\"events_icon\"> </div>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(3) .events_icon").append("<strong> Time </strong>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(3) .events_icon").append("<span>" + hour + ":" + minutes + "</span>");
                $("#event_page .row:nth-child(" + (i + 1) + ") .col:nth-child(3) .events_icon").append("<em>" + ampm + "</em>");
            }
        }
    });
}
function fix_about_body() {

    var height_ = window.innerHeight - $('nav#nav').height() - $(".about_image").height();
    var body_height = height_;
    $(".about_body").css("height",height_+"px");
    $(".meet_directors").height(body_height - $(".meet").height() - $(".members_viewing h1").height() - 25);

}
//gallery
jQuery(document).ready(function ($) {
    // fix_about_body();
    //alert("test");
    var options = {
        $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
            $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
            $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
        },

        $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
            $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
            $ChanceToShow: 2                                //[Required] 0 Never, 1 Mouse Over, 2 Always
        }
    };
    var jssor_slider1 = new $JssorSlider$("slider1_container", options);

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizing
    function ScaleSlider() {
        var parentWidth = jssor_slider1.$Elmt.parentNode.clientWidth;

        var nav = $("nav").height();
        var max_width = ((window.innerHeight-nav-$(".gallery_image").height()-30) * 3)/2;

        $(".myslide").css("max-width", max_width.toString() + "px");
        $(".gallerybody").css("max-width", max_width.toString() + "px");
        $(".myslide").css("display","block");
        $("*:not(form)").removeClass("hide");
        $(".loading").addClass("hide");
        // //////alert("test");
        if (parentWidth) {
            jssor_slider1.$ScaleWidth(parentWidth);
        }
        else
            window.setTimeout(ScaleSlider, 30);

    }
    ScaleSlider();

    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);
    //responsive code end
});
setInterval(moveTitle, 300);

//login and sign up buttons

function sign_in() {
    $("#sign-in").removeClass("hide");
    $("#sign-up").addClass("hide");
}
function sign_up() {
    $("#sign-up").removeClass("hide");
    $("#sign-in").addClass("hide");
}

//editing data
$(document).ready(function() {
    $("#myTable").tablesorter();
} );


var whattochange = "";
function name_() {
    whattochange = "name";
}
function rank() {
    whattochange = "rank";
}
function edit_contact_info(user,rank = 0,selfrank) {




    if (whattochange === "name") {
        var value = $("#user"+user+" th:nth-child(1)").text();

        if (value.length >= 16 && value.substring(value.length-16,value.length) === "[RESET PASSWORD]") {
            value = value.substring(0,value.length-22);
        } else {
            value = value.substring(0,value.length-6);
        }

        var first = "";
        var last = "";
        for (var i =0; value[i] != " ";++i) {
            first += value[i];

        }
        ++i;
        for (;i < value.length;++i) {
            last += value[i];
        }
        $("#user"+user+" th:nth-child(1)").replaceWith("<th><form action=\'includes/editcontact-inc.php\' method=\'post\'>\n    <input type=\'text\' name=\'first\' value=\'" + first + "\'>\n    <input type=\'text\' name=\'last\' value=\'" + last + " \'>\n    <input hidden type=\'text\' name=\'id\' value=\' " + user + "\'>\n    <input type=\'submit\' value=\'Done\'>\n" +
            "</form></th>");


    }else if (whattochange == "rank") {
        var sel = ["","",""];
        sel[rank] = "selected";
        if (selfrank > 2 || true) {
            $("#user" + user + " th:nth-child(5)").replaceWith("<th><form action=\'includes/editcontact-inc.php\' method=\'post\'>\n    <select name=\'rank\' required>\n        <option " + sel[0] + " value=\'-1\'>REJECT</option>\n        <option " + sel[1] + "value=\'1\'>Member</option>\n        <option value=\'1.1\'>Alumni</option>\n        <option " + sel[2] + " value=\'2\'>Director</option>\n        <option value=\'3\'>Admin</option>\n    </select>\n    <input hidden type=\'text\' name=\'id\' value=\' " + user + "\'>\n    <input type=\'submit\' value=\'Done\'>\n" +
                "</form></th>");
        } else {

        }
    }
}
function modify_email(type, which, user) {

    var value = $("#user"+user+" th:nth-child(2) div:nth-child(" + (which + 1) + ")").text();
    value = value.substring(0,value.length-14);
    if (type == "edit") {
        $("#user"+user+" th:nth-child(2) div:nth-child(" + (which + 1) + ")").replaceWith('<form action=\'includes/editcontact-inc.php\' method=\'post\'>\n' +
            '    <input type=\'email\' required name=\'email\' value=\' ' + value + ' \'>' +
            '\n' +
            '    <input hidden type=\'text\' name=\'id\' value=\' ' + user + ' \'>\n    <input hidden type=\'text\' name=\'which\' value=\' ' + which + ' \'>\n' +
            '    <input type=\'submit\' value=\'Done\'>\n' +
            '</form>');
    } else if (type == "remove") {
        $.ajax({
            method: "POST",
            url: "../includes/editcontact-inc.php",
            data: { which: which, id: user, remove: "remove", email:"email" }
        })
            .done(function( msg ) {
                location.reload();
            });
    } else {
        $("#user"+user+" th:nth-child(2) > span" ).replaceWith('<form action=\'includes/editcontact-inc.php\' method=\'post\'>\n' +
            '    <input type=\'email\' name=\'email\' value=\' ' + value + ' \'>' +
            '\n' +
            '    <input hidden type=\'text\' name=\'id\' value=\' ' + user + ' \'>\n    <input hidden type=\'text\' name=\'which\' value=\' ' + which + ' \'>\n' +
            '    <input type=\'submit\' value=\'Done\'>\n' +
            '</form>');
    }
}
function modify_phone(type,which,user) {
    var value = [$("#user"+user+" th:nth-child(3) div:nth-child(" + (which + 1) + ") span:nth-child(1)").text(),$("#user"+user+" th:nth-child(3) div:nth-child(" + (which + 1) + ") span:nth-child(2)").text()];
    console.log(value[0] + "XXXXXXXXXX" + value[1]);

    if (type == "edit") {
        $("#user"+user+" th:nth-child(3) div:nth-child(" + (which + 1) + ")").replaceWith('<form action=\'includes/editcontact-inc.php\' method=\'post\'>\n    <input type=\'text\' name=\'phone_belongs\' value=\' ' + value[0] + '  \'>\n' +
            '    <input type=\'tel\' required name=\'phone_num\' value=\' ' + value[1] + ' \'>' +
            '\n' +
            '    <input hidden type=\'text\' name=\'id\' value=\' ' + user + ' \'>\n    <input hidden type=\'text\' name=\'which\' value=\' ' + which + '  \'>\n' +
            '    <input type=\'submit\' value=\'Done\'>\n' +
            '</form>');
    } else if (type == "remove") {
        $.ajax({
            method: "POST",
            url: "../includes/editcontact-inc.php",
            data: { which: which, id: user, remove: "remove", phone_num:"phone_num" }
        })
            .done(function( msg ) {
                location.reload();
            });
    } else {
        $("#user"+user+" th:nth-child(3) > span" ).replaceWith('<form action=\'includes/editcontact-inc.php\' method=\'post\'>\n    <input name="phone_belongs" type="text" placeholder="mom cell">\n    <input name="phone_num" type="tel" placeholder="888 888 8888">\n    <input hidden type=\'text\' name=\'id\' value=\' ' + user + '   \'>\n    <input hidden type=\'text\' name=\'which\' value=\' ' + (which + 1) + '  \'>\n    <input type=\'submit\' value=\'Done\'>\n' +
            '' +
            '' +
            '</form>');
    }
}
function modify_address(user) {
    var value = [$("#user"+user+" th:nth-child(4) div:nth-child(1)").text(),$("#user"+user+" th:nth-child(4) div:nth-child(2)").text(),$("#user"+user+" th:nth-child(4) div:nth-child(3)").text(),$("#user"+user+" th:nth-child(4) div:nth-child(4)").text()];


    $("#user"+user+" th:nth-child(4)").replaceWith('<th><form action=\'includes/editcontact-inc.php\' method=\'post\'>\n<input name="street" placeholder="address" value="' + value[0] + '"><br>\n<input name="city" placeholder="city" value="' + value[1] + '"><br>\n<input name="state" placeholder="state" value="' + value[2] + '"><br>\n<input name="zip" placeholder="zip" value="' + value[3] + '"><br>\n    <input hidden type=\'text\' name=\'id\' value=\' ' + user + '  \'>\n    <input type=\'submit\' value=\'Done\'>\n</form></th>')
}



function add_info(type,name) {
    var result = $.ajax({
        url: 'includes/add_user_lookup_file-inc.php', //This is the current doc
        type: "POST",
        data: ({type: type,name:name})
    })
        .done(function(e) {
            // alert(e);
        })
        .fail(function() {
            // alert("error")
        });
}

function delete_(type, video_name) {
    // alert("type:" + type + " video_name: " + video_name);
    $.ajax({
        method: "POST",
        url: "includes/delete_practice_video-inc.php",
        data: { video_name: video_name, type: type}
    })
        .done(function( which ) {
            if (type === "schedule") {
                window.location.href = 'schedule.php';
            } else if (type === "video") {

                window.location.href = 'Instruction_Videos.php';
            } else {
                window.location.href = 'practice_part.php';
            }
        });
}
//this comment should show up

//tests below here

function testreplace(id) {
    $(id).replaceWith("<p>This is a test</p>")
}