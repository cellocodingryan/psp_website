function stat(stat) {
    $.ajax({
        method: "POST",
        url: "api.php?method=add_stat",
        //play_pause 0=playing
        data: {stat}
    })
}