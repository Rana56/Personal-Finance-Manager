document.querySelector("#show-budget").addEventListener("click", function(){
    $('#budgetPopup').fadeIn();
    document.querySelector("#budgetPopup").classList.add("active");
    console.log("test");
});

document.querySelector("#popup-close-budget").addEventListener("click", function(){
    $('#budgetPopup').fadeOut();
    document.querySelector("#budgetPopup").classList.remove("active");
    console.log("close");
});
