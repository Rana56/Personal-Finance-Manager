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
        url: "php/budgetGraph.php", 
        method: "GET",
        dataType: 'json',
        success: function(response) {
            //Test
            console.log(response.map(item => item.category));
            console.log(response.map(item => item.budget));
            console.log(response.map(item => item.categoryTotal));
            
            //draw chart with response data
            new Chart("currentBalance", {
                type: "bar",
                data: {
                    labels: response.map(item => item.category),
                    datasets: [{
                            label: 'Budget £',
                            backgroundColor: "#E07E76",
                            data: response.map(item => item.budget)
                        },
                        {
                            label: 'Spending £',
                            backgroundColor: "#E076A3",
                            data: response.map(item => item.categoryTotal)
                        }
                    ]
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

});