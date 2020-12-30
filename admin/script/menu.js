function toggleMenu(e){
    e.preventDefault();
    document.querySelector('nav > ul').classList.toggle('visible');
}
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('nav > button').addEventListener('click', toggleMenu);
    document.querySelector('nav > button').addEventListener('touchstart', toggleMenu);
});


