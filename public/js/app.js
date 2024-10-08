document.addEventListener("DOMContentLoaded", function () {
    const regforms = document.getElementsByClassName("regform");
    const regbutts = document.getElementsByClassName("regbutt"); //classname returns a list

    for (let i = 0; i < regforms.length; i++) {
        regforms[i].addEventListener("submit", function () {
            regbutts[i].disabled = true;
            regbutts[i].innerText = "loading...";
        });
    }
});
