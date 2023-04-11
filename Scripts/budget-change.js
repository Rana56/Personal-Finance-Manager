$(document).ready(function() {

    //Add Budget
    // Intercept the form submission
    $('#budgetForm').submit(function(event) {
        // Stops the form from submitting normally
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'php/budgetAddData.php',
            data: formData,
            success: function(response) {
                // Show the response from the server
                //$('#response').html(response);
                console.log(response);
                alert(response);
                window.location.reload();
            },
            error: function(jqXHR, textStatus, errorThrown, response){
                console.log(errorThrown);
                console.log(jqXHR);
                console.log(response);
                
            }
        });
    });

    //Remove Budget
    $(".delete-budget").click(function() {
        var budgetID = $(this).data("budget-id");
    
        //AJAX request to remove row from database and update table
        $.ajax({
            url: "php/budgetRemoveData.php", 
            method: "POST",
            data: {budget_id: budgetID},
            success: function(reponse) {
                alert("Budget Deleted");
                document.getElementById("budgets").innerHTML = reponse;
                //console.log('delete', budgetID);

            }, 
            error: function(jqXHR, textStatus, errorThrown, response){
                console.log(errorThrown);
                console.log(jqXHR);
                console.log(response);
            }
        });

    });
});
