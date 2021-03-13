/**
 * Created by cellocodingryan on 1/17/18.
 */

async function upload_file(formElement,callback) {
    let formElements = formElement.children('input[type="file"]');
    console.log(formElements);

    if (formElements.length == 0) {
        return;
    }

    let url = formElements.attr("action") === undefined ? window.location.pathname.substr(1) : formElements.attr("action");


    let filename = formElements.attr("name");

    let json = formElement.serializeArray();

    return new Promise(async (resolve, reject) => {

        var file = formElements.prop('files')[0]
        console.log(file);
        if (file == null) {
            return null;
        }



        const chunkSize = 1000000;
        var startbool = 1;
        var start = 0;
        var count = 0;
        console.log(file)
        for (; start < file.size; start += chunkSize,++count) {
            const chunk = file.slice(start, start + chunkSize);
            const fd = new FormData;
            console.log(json);
            json.forEach((value)=>{
                fd.append(value.name,value.value)
            })


            fd.append(filename, chunk,file.name);
            var complete = 0;
            if (start+chunkSize >= file.size){
                complete = 1;
            }

            fd.append("complete",complete);
            fd.append("start",startbool);
            console.log(fd);
            startbool=0;
            console.log("Tet123");
            await fetch(url, {method: 'post', body: fd})
                // .then(response => response.text())
                // .then(json => console.log(json))
                .then(function() {
                    var percent = Math.round(((start+chunkSize)/file.size)*100);
                    if (percent > 100) {
                        percent=100
                    }
                    callback(percent);
                    console.log(percent);
                })
                .catch(function (error) {
                    console.log('Request failed', error);
                    location.reload();
                });
        }

        console.log("DONE!");
        resolve();
    })
}


$('form').one('submit',function(e) {
    e.preventDefault();

    let callback = (percent)=> {
        $('.percentdone').text(percent+"%");
    }

    upload_file($(this),callback).then(res=> {
        location.reload();
    });


})