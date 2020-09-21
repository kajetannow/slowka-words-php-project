var open = document.querySelector('.open-menu');
var close = document.querySelector('.close-menu');
var loginPanel = document.querySelector('.login-panel');
var header = document.querySelector('header');
var menu = document.querySelector('nav');
isOpen = false;

function closeMenu(){
    menu.style.animationName = "fadeOut";
    function handler(){
        if(isOpen){
            loginPanel.style.display = "none";
            menu.removeChild(loginPanel);
            menu.style.display = "none";
            menu.removeEventListener("animationend", handler);
            isOpen = false;
        }
    }
    menu.addEventListener("animationend", handler);
}
function openMenu(){
    menu.style.display = "flex";
    menu.style.animationName = "fadeIn";
    loginPanel.style.display = "flex";
    loginPanel.classList.add("mobile-login-panel");
    menu.appendChild(loginPanel);
    isOpen = true;
}

//header.removeChild(loginPanel);
loginPanel.classList.add("hide-mobile");

open.addEventListener("click", openMenu);
close.addEventListener("click", closeMenu);