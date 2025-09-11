const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

const wrong = document.getElementsByClassName('wrong');

const signupForm = document.getElementById('signupForm');
const signinForm = document.getElementById('signinForm');

const upfname = document.getElementById("FnameUP").value.trim();
const uplname = document.getElementById("LnameUP").value.trim();
const upemail = document.getElementById("EmailUP").value.trim();
const uppassword = document.getElementById("PasswordUP").value;
const uprepassword = document.getElementById("RePasswordUP").value;

const inemail = document.getElementById("EmailIN").value.trim();
const inpassword = document.getElementById("PasswordIN").value;

const nameparrtern = /^[a-zA-Z]+$/;
const emailpattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});


signupForm.addEventListener('submit', (e) => { 
    if(upfname === "" || !nameparrtern.test(upfname)) {
        wrong[0].style.display = "line";
        e.preventDefault();
        return;
    }
});

