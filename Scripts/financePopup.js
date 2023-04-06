document.querySelector("#show-incomePopup").addEventListener("click", function(){
        document.querySelector("#incomePopup").classList.add("active");
        console.log("test");
});

document.querySelector("#popup-close-btn").addEventListener("click", function(){
    document.querySelector("#incomePopup").classList.remove("active");
});