const uploadForm=document.getElementById("uploadForm");
const  inpFile = document.getElementById("inpFile");
const progressBarFill= document.querySelector("#progressBar > .progress-bar-fill");
const progressBarText= progressBarFill.querySelector(".progress-bar-text");

uploadForm.addEventListener("submit",'uploaFile.php');

const xhr = new XMLHttpRequest();
xhr.open('POST','/upload');
xhr.upload.addEventListener('progress', e=> {
    const percent = e.lengthComputable ? (e.loaded / e.total) * 100 : 0;

    progressBarFill.width = percent.toFixed(2)
});
xhr.setRequestHeader("Content-Type", "multipart/form-data");
xhr.send(new FormData(uploadForm));
