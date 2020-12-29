
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('nav > button').addEventListener('click', function(e){
        e.preventDefault();
        document.querySelector('nav > ul').classList.toggle('visible');
    });
});