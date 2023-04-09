$(document).ready(function(){
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

    //AJAX request to get data from database
    // ------- Pie chart ------- 
    $.ajax({
        url: "php/financePieGraph.php", 
        method: "GET",
        dataType: 'json',
        success: function(response) {
            //Test
            console.log(response.map(item => item.category));
            
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
            
                //tool tip error, legend padding

        }, 
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(jqXHR);
        }
    });

    // ------- Line chart ------- 
    $.ajax({
        url: "php/financeBalanceGraph.php", 
        method: "GET",
        dataType: 'json',
        success: function(response) {      
            //Test
            console.log(response.map(item => item.incomeDate));

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
            
         //legend padding

        }, 
        error: function(jqXHR, textStatus, errorThrown){
            console.log(errorThrown);
            console.log(jqXHR);
        }
    });


});