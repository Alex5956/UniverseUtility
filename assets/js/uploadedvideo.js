const $ = require('jquery');
uploadForm=document.getElementById("uploadForm");
inputFile=document.getElementsByTagName('input[type=file]');
console.log(inputFile);
const progressBarFill= document.querySelector("#progressBar > .progress-bar-fill");
const progressBarText= progressBarFill.querySelector(".progress-bar-text");

uploadForm.addEventListener("submit",uploadFile);
function uploadFile(e) {
    let uploadDataForm = new FormData(uploadForm);
//uploadDataForm.append('file' ,'fichier');
    for(var value of uploadDataForm.values()) {
        console.log(value);
    }
    // $.ajax({
    //     type: "POST",
    //     url: '/' ,
    //     data: {
    //          uploadDataForm
    //     },
    //     enctype: 'multipart/form-data',
    //     processData: false,
    //     contentType: false,
    //     error: function (error){
    //         console.error(error);
    //     },
    //     success: function(response) {
    //
    //     }
    // });
    e.preventDefault();
    try {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/');
        console.log('coucou');
        xhr.upload.addEventListener('progress', e => {
            const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
            console.log('coucou2');
            progressBarFill.width = percent.toFixed(2)
        });
        xhr.setRequestHeader("Content-Type", "multipart/form-data");
        xhr.send(uploadDataForm);
    }
    catch (error){
        console.error(error);
    }

}
