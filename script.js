function Set() {
    localStorage.setItem("content", document.getElementById("set").innerHTML);
}

function Get() {
    if("content" in localStorage) {
        document.getElementById("get").innerHTML = decodeURI(localStorage.getItem("content"));
        localStorage.setItem("content", document.getElementById("set").innerHTML);
    }
    else {
        document.getElementById("get").innerHTML = "No saved content";
    }
}