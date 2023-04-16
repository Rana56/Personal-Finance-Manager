//get dropdown element
const dropdowns = document.querySelectorAll('.dropdown');

//loop through all dropdown elements
dropdowns.forEach(dropdown => {
    //inner elements
    const select = dropdown.querySelector('.select');
    const caret = dropdown.querySelector('.caret');
    const menu = dropdown.querySelector('.menu');
    const options = dropdown.querySelectorAll('.menu li');
    const selected = dropdown.querySelector('.selected');

    //click lister to select elements
    select.addEventListener('click', () => {
        select.classList.toggle('select-clicked');
        caret.classList.toggle('caret-rotate');
        menu.classList.toggle('menu-open');
    });

    //loop throuugh all option elements
    options.forEach(option => {
        
        //click event to all elements
        option.addEventListener('click', () => {
            //set text filter text to option text
            selected.innerText = option.innerText;
            select.classList.remove('select-clicked');
            caret.classList.remove('caret-rotate');
            menu.classList.remove('menu-open');
            
            options.forEach(option => {
                option.classList.remove('active');
            });
            //add active class to clicked element
            option.classList.add('active');
        });  
    });
});

$(document).ready(function(){
    loadFilter("month");
});

function loadFilter(filter) {
    //ajax request
    $.ajax({
        url: "php/accountFilter.php", 
        method: "GET",
        data: {filter_data: filter},
        dataType: 'json',
        success: function(response) {
            updatePage(response, filter);

        }, 
        error: function(jqXHR, textStatus, errorThrown, response){
            console.log(errorThrown);
            console.log(jqXHR);
            console.log(response);
        }
    });
}

function updatePage(response, filter){
    document.getElementById("filterIncome").textContent="£" + response.map(item => item.income);
    document.getElementById("filterExpense").textContent="£" + response.map(item => item.expense);
    var filterDetail = document.querySelectorAll(".filterDetails");

    if(filter === "week"){
        filterDetail.forEach(element => {
            element.textContent="This Week";
        });
    }
    else if(filter === "month"){
        filterDetail.forEach(element => {
            element.textContent="This Month";
        });
    }
    else if(filter === "year"){
        filterDetail.forEach(element => {
            element.textContent="This Year";
        });
    }
    else if(filter === "all"){
        filterDetail.forEach(element => {
            element.textContent="Overall";
        });
    }
    else {
        filterDetail.forEach(element => {
            element.textContent="This Month";
        });
    }
}


