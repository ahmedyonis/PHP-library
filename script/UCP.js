const sidebar = document.getElementById('sidebar');
const toggleBtn = document.getElementById('toggleSidebar');
const mainContent = document.getElementById('mainContent');
const header = document.getElementById('header');
const footer = document.getElementById('footer');


toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    toggleBtn.classList.toggle('open');
    mainContent.classList.toggle('shifted');
    header.classList.toggle('shifted');
    footer.classList.toggle('shifted');

});




function enableEditing() {
    document.getElementById('firstname').disabled = false;
    document.getElementById('lastname').disabled = false;
    document.getElementById('email').disabled = false;
    document.getElementById('password').disabled = false;
    document.getElementById('editBtn').disabled = false;
}
