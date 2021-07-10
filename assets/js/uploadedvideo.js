const uploadForm=document.getElementById("uploadForm");
console.log(uploadForm);
const progressBarFill= document.querySelector("#progressBar > .progress-bar-fill");
const progressBarText= progressBarFill.querySelector(".progress-bar-text");

//uploadForm.addEventListener("submit",uploadFile);
function uploadFile(e) {
    e.preventDefault();

    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/');
    console.log('coucou');
    xhr.upload.addEventListener('progress', e => {
        const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;
        console.log('coucou2');
        progressBarFill.width = percent.toFixed(2)
    });
    xhr.setRequestHeader("Content-Type", "multipart/form-data");
    xhr.send(new FormData(uploadForm));

}
