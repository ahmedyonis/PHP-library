const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
    sessionStorage.setItem("now", "register");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
    sessionStorage.setItem("now", "login");
});


window.onload = function () { 
    if (sessionStorage.getItem("now") === "register") {
        container.classList.add("active");
    } else {
        container.classList.remove("active");
    }
}



