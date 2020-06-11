/**
 * Created by cellocodingryan on 1/17/18.
 */



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