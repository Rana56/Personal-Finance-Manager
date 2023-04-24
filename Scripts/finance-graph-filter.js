//colours
var barColors = [
    "#b91d47",
    "#00aba9",
    "#2b5797",
    "#e8c3b9",
    "#1e7145",
    "#001219",
    "#94D2BD",
    "#E9D8A6",
    "#EE9B00",
    "#CA6702",
    "#BB3E03",
    ];

var barColors2 = [

    "#1e7145",
    "#b5a886",
    "#fee1c7",
    "#fa7e61",
    "#EE9B00",
    "#CA6702",
    "#BB3E03",    
    "#b91d47",
    "#00aba9",
    "#2b5797",
    "#e8c3b9",
    ];

$(document).ready(function(){

    //AJAX request to get data from database
    categoryGraph("month");
    incomeGraph("month");
    expenseGraph("month");
    getTotal("month");
});

function categoryGraph(filter){
    // ------- Pie chart ------- 
    $.ajax({
        url: "php/financePieGraph.php", 
        method: "GET",
        data: {filter_data: filter},
        dataType: 'json',
        success: function(response) {
            //Test
            console.log(response.map(item => item.category));

            $('#pieChart').remove();
            $('#categoryGraph').append('<canvas id="pieChart" style="width:100%;max-width:300px" aria-label="Element not supported"></canvas>');

            //draw chart with response data
            new Chart("pieChart", {
                type: "doughnut",
                data: {
                    labels: response.map(item => item.category),
                    datasets: [{
                        label: 'Expense £',
                        backgroundColor: barColors,
                        data: response.map(item => item.total)
                    }]
                },
                options: {
                    title: {
                        display:true,
                        text: "Total spending for categories"
                    },
                    layout: {
                        padding: {
                            top: 10
                        }
                    }
                }
            });

        }, 
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(jqXHR);
        }
    });
}

function incomeGraph(filter){
    // ------- Line chart ------- 
    $.ajax({
        url: "php/financeBalanceGraph.php", 
        method: "GET",
        data: {filter_data: filter},
        dataType: 'json',
        success: function(response) {      
            //Test
            console.log(response.map(item => item.incomeDate));

            //removes element to draw another graph
            $('#lineGraph').remove();
            $('#incomeGraph').append('<canvas id="lineGraph" style="width:100%;max-width:auto" aria-label="Element not supported"></canvas>');

            //draw chart with response data
            new Chart("lineGraph", {
                type: "line",
                data: {
                    labels: response.map(item => item.incomeDate),
                    datasets: [{
                        label: 'Income',
                        data: response.map(item => item.incomeTotal),
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            top: 10
                        }
                    },
                }
            });

        }, 
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(jqXHR);
        }
    });
}


function expenseGraph(filter){
    // ------- Line chart ------- 
    $.ajax({
        url: "php/financeExpenseGraph.php", 
        method: "GET",
        data: {filter_data: filter},
        dataType: 'json',
        success: function(response) {      
            //Test
            console.log(response.map(item => item.incomeDate));

            $('#expenseChart').remove();
            $('#expenseGraphBox').append('<canvas id="expenseChart" style="width:100%;max-width:auto" aria-label="Element not supported"></canvas>');

            //draw chart with response data
            new Chart("expenseChart", {
                type: "bar",
                data: {
                    labels: response.map(item => item.date),
                    datasets: [{
                        label: 'Expense',
                        data: response.map(item => item.total),
                        backgroundColor: barColors2,
                        borderWidth:1
                    }]
                },
                options: {
                    layout: {
                        padding: {
                            top: 10
                        }
                    },
                }
            });

        }, 
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(jqXHR);
        }
    });
}


//-------------------Filter-------------------------

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

function loadFilter(filter) {
    categoryGraph(filter);
    incomeGraph(filter);
    expenseGraph(filter);
    getTotal(filter);
}

function getTotal(filter) {
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
   
    var income ="£" + response.map(item => item.income);
    var expense ="£" + response.map(item => item.expense);

    if(filter === "week"){
        document.getElementById("expenseText").textContent = "Total Expense this week: " + expense; 
        document.getElementById("totalInfo").textContent = "Total Income this week: " + income;
    }
    else if(filter === "month"){
        document.getElementById("expenseText").textContent = "Total Expense this month: " + expense; 
        document.getElementById("totalInfo").textContent = "Total Income this month: " + income;
    }
    else if(filter === "year"){
        document.getElementById("expenseText").textContent = "Total Expense this year: " + expense; 
        document.getElementById("totalInfo").textContent = "Total Income this year: " + income;
    }
    else if(filter === "all"){
        document.getElementById("expenseText").textContent = "Total Expense overall: " + expense; 
        document.getElementById("totalInfo").textContent = "Total Income overall: " + income;
    }
    else {
        document.getElementById("expenseText").textContent = "Total Expense this month: " + expense; 
        document.getElementById("totalInfo").textContent = "Total Income this month: " + income;
    }
}