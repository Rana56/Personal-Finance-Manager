document.querySelector("#show-incomePopup").addEventListener("click", function(){
        document.querySelector("#incomePopup").classList.add("active");
        console.log("test");
});

document.querySelector("#show-expensePopup").addEventListener("click", function(){
    document.querySelector("#expensePopup").classList.add("active");
    console.log("test2");
});

document.querySelector("#popup-close-income").addEventListener("click", function(){
    document.querySelector("#incomePopup").classList.remove("active");
    console.log("close");
});

document.querySelector("#popup-close-expense").addEventListener("click", function(){
    document.querySelector("#expensePopup").classList.remove("active");
    console.log("close");
});
