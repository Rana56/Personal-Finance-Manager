const sidebar = document.querySelector("aside");
const menuButton = document.querySelector("#menu-btn")
const closeButton = document.querySelector("#close-btn")
const toggle = document.querySelector(".colour-toggle")

toggle.addEventListener('click', () =>{
    document.body.classList.toggle('dark-theme');

    toggle.querySelector('span:nth-child(1)').classList.toggle('active');
    toggle.querySelector('span:nth-child(2 )').classList.toggle('active');
})