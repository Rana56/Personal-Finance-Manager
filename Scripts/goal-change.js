$(document).ready(function() {

    //Add Budget
    // Intercept the form submission
    $('#goalForm').submit(function(event) {
        // Stops the form from submitting normally
        event.preventDefault();

        // Get the form data
        var formData = $(this).serialize();

        $.ajax({
            type: 'POST',
            url: 'php/goalAddData.php',
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
    $(".remove-goal").click(function() {
        var goalID = $(this).data("goal-id");
    
        //AJAX request to remove row from database and update table
        $.ajax({
            url: "php/goalRemoveData.php", 
            method: "POST",
            data: {goal_id: goalID},
            success: function(reponse) {
                alert("Goal Deleted");
                window.location.reload();
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
