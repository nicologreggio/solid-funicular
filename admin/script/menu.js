"use strict";
// già con sintassi ie 6, ie_mob 9
function toggleMenu(e){
    e.preventDefault();
    document.querySelector('nav > ul').classList.toggle('visible');
}
document.addEventListener("DOMContentLoaded", function() {
    document.querySelector('nav > button').addEventListener('click', toggleMenu);
    document.querySelector('nav > button').addEventListener('touchstart', toggleMenu);
    if(document.location.hash) {
        setTimeout(()=> {
            document
              .querySelector(document.location.hash)
              .scrollIntoView({ block: "start" })
        }, 300)
      }
});


